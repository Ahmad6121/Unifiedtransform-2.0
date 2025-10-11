<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SchoolSession;
use App\Interfaces\UserInterface;
use App\Interfaces\SectionInterface;
use App\Interfaces\SchoolClassInterface;
use App\Repositories\PromotionRepository;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\TeacherStoreRequest;
use App\Interfaces\SchoolSessionInterface;
use App\Repositories\StudentParentInfoRepository;

class UserController extends Controller
{
    use SchoolSession;
    protected $userRepository;
    protected $schoolSessionRepository;
    protected $schoolClassRepository;
    protected $schoolSectionRepository;

    public function __construct(UserInterface $userRepository, SchoolSessionInterface $schoolSessionRepository,
    SchoolClassInterface $schoolClassRepository,
    SectionInterface $schoolSectionRepository)
    {
        $this->middleware(['can:view users']);

        $this->userRepository = $userRepository;
        $this->schoolSessionRepository = $schoolSessionRepository;
        $this->schoolClassRepository = $schoolClassRepository;
        $this->schoolSectionRepository = $schoolSectionRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TeacherStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeTeacher(TeacherStoreRequest $request)
    {
        try {
            $this->userRepository->createTeacher($request->validated());

            return back()->with('status', 'Teacher creation was successful!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function getStudentList(Request $request)
    {
        $current_school_session_id = $this->getSchoolCurrentSession();

        $class_id = $request->query('class_id', 0);
        $section_id = $request->query('section_id', 0);

        try {
            $school_classes = $this->schoolClassRepository->getAllBySession($current_school_session_id);
            $user = auth()->user();

            if ($user->hasRole('teacher')) {
                // جلب الصفوف المرتبطة بالمعلم
                $teacherClasses = $user->teacherCourses()->pluck('class_id')->toArray();

                // جلب الطلاب لكن فقط من صفوف المعلم
                $studentList = $this->userRepository
                    ->getAllStudents($current_school_session_id, $class_id, $section_id)
                    ->whereIn('class_id', $teacherClasses);
            } else {
                // للأدمن أو أي دور آخر
                $studentList = $this->userRepository->getAllStudents($current_school_session_id, $class_id, $section_id);
            }

            $data = [
                'studentList'    => $studentList,
                'school_classes' => $school_classes,
            ];

            return view('students.list', $data);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }



    public function showStudentProfile($id) {
        $student = $this->userRepository->findStudent($id);

        $current_school_session_id = $this->getSchoolCurrentSession();
        $promotionRepository = new PromotionRepository();
        $promotion_info = $promotionRepository->getPromotionInfoById($current_school_session_id, $id);

        $data = [
            'student'           => $student,
            'promotion_info'    => $promotion_info,
        ];

        return view('students.profile', $data);
    }

    public function showTeacherProfile($id) {
        $teacher = $this->userRepository->findTeacher($id);
        $data = [
            'teacher'   => $teacher,
        ];
        return view('teachers.profile', $data);
    }


    public function createStudent()
    {
        // 1️⃣ احصل على الـ session الحالية أو آخر واحدة موجودة
        $current_school_session_id = $this->getSchoolCurrentSession() ??
            \App\Models\SchoolSession::latest()->value('id');

        // 2️⃣ اجلب الصفوف والشعب بناءً على session_id (أو الكل إذا لم نجد)
        $school_classes = $current_school_session_id
            ? $this->schoolClassRepository->getAllBySession($current_school_session_id)
            : $this->schoolClassRepository->getAll();

        $sections = $current_school_session_id
            ? \App\Models\Section::where('session_id', $current_school_session_id)->get()
            : \App\Models\Section::all();

        // 3️⃣ لو ما في صفوف أو شعب، لا نمنع المستخدم — فقط نظهر رسالة تحذير
        if ($school_classes->isEmpty() || $sections->isEmpty()) {
            session()->flash('warning', '⚠️ لم يتم العثور على صفوف أو شعب مرتبطة بالـ Session الحالية. سيتم عرض كل الصفوف والشعب المتاحة.');
        }

        $data = [
            'current_school_session_id' => $current_school_session_id,
            'school_classes'            => $school_classes,
            'sections'                  => $sections, // 🆕 تمرير الشعب للـ Blade
        ];

        return view('students.add', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  StudentStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeStudent(StudentStoreRequest $request)
    {
        try {
            $this->userRepository->createStudent($request->validated());

            return back()->with('status', 'Student creation was successful!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function editStudent($student_id) {
        $student = $this->userRepository->findStudent($student_id);
        $studentParentInfoRepository = new StudentParentInfoRepository();
        $parent_info = $studentParentInfoRepository->getParentInfo($student_id);
        $promotionRepository = new PromotionRepository();
        $current_school_session_id = $this->getSchoolCurrentSession();
        $promotion_info = $promotionRepository->getPromotionInfoById($current_school_session_id, $student_id);

        $data = [
            'student'       => $student,
            'parent_info'   => $parent_info,
            'promotion_info'=> $promotion_info,
        ];
        return view('students.edit', $data);
    }

    public function updateStudent(Request $request) {
        try {
            $this->userRepository->updateStudent($request->toArray());

            return back()->with('status', 'Student update was successful!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function editTeacher($teacher_id) {
        $teacher = $this->userRepository->findTeacher($teacher_id);

        $data = [
            'teacher'   => $teacher,
        ];

        return view('teachers.edit', $data);
    }
    public function updateTeacher(Request $request) {
        try {
            $this->userRepository->updateTeacher($request->toArray());

            return back()->with('status', 'Teacher update was successful!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function getTeacherList(){
        $teachers = $this->userRepository->getAllTeachers();

        $data = [
            'teachers' => $teachers,
        ];

        return view('teachers.list', $data);
    }


}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4"><i class="bi bi-people"></i> My Children</h1>

        <div class="card p-3 shadow-sm">
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="ابحث باسم ابنك أو بريده...">

            <table class="table table-bordered table-hover" id="childrenTable">
                <thead class="table-light">
                <tr>
                    <th>ID Card</th>
                    <th>Photo</th>
                    <th>Child First Name</th>
                    <th>Child Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($children as $child)
                    @php
                        $student   = $child->student;
                        $promotion = $student->promotion ?? null;
                    @endphp

                    @if($student)
                        <tr>
                            <td>{{ $promotion->id_card_number ?? '-' }}</td>
                            <td>
                                @if ($student->photo)
                                    <img src="{{ asset('/storage'.$student->photo) }}" width="35" class="rounded">
                                @else
                                    <i class="bi bi-person-square"></i>
                                @endif
                            </td>
                            <td class="student-name">{{ $student->first_name }}</td>
                            <td>{{ $student->last_name }}</td>
                            <td class="student-email">{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>
                                <a href="{{ route('student.profile.show', $student->id) }}" class="btn btn-sm btn-outline-primary">
                                    View Profile
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // 🔎 بحث سريع باسم أو إيميل الطفل
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const term = this.value.toLowerCase();
            const rows = document.querySelectorAll('#childrenTable tbody tr');

            rows.forEach(row => {
                const name  = row.querySelector('.student-name').textContent.toLowerCase();
                const email = row.querySelector('.student-email').textContent.toLowerCase();

                row.style.display = (name.includes(term) || email.includes(term)) ? '' : 'none';
            });
        });
    </script>
@endsection


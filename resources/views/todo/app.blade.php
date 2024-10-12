<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>simple CRUD</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #6a11cb, #2575fc);
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
        }
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.9);
        }
        .list-group-item {
            border: none;
            border-radius: 8px;
            background-color: #ffffff;
            transition: background-color 0.3s;
        }
        .list-group-item:hover {
            background-color: #f1f1f1;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }
        .edit-btn {
            margin-left: 10px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }
        .task-text {
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">simple CRUD</a>
        </div>
    </nav>
    
    <div class="container mt-4">
        <h1 class="text-center mb-4">simple CRUD</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Form input data -->
                        <form id="todo-form" action="{{ url('/todo') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="task" id="todo-input" placeholder="Tambah task baru" required>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <!-- Searching -->
                        <form id="search-form" action="{{ url('/todo') }}" method="get">
                            <div class="input-group mb-3">
                                <select name="category_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button class="btn btn-secondary" type="submit">Cari</button>
                            </div>
                        </form>
                        
                        <ul class="list-group mb-4" id="todo-list">
                            <!-- Display Data -->
                            @foreach ($todos as $todo)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="task-text">{{ $todo->task }} <small class="text-muted">({{ $todo->category->name }})</small></span>
                                    <div>
                                        <form action="{{ url('/todo/' . $todo->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                        <button class="btn btn-primary btn-sm edit-btn" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $todo->id }}" aria-expanded="false"><i class="fas fa-edit"></i></button>
                                    </div>
                                </li>
                                <!-- Update Data -->
                                <li class="list-group-item collapse" id="collapse-{{ $todo->id }}">
                                    <form action="{{ url('/todo/' . $todo->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="task" value="{{ $todo->task }}" required>
                                            <button class="btn btn-outline-primary" type="submit">Update</button>
                                        </div>
                                        <div class="d-flex">
                                            <div class="radio px-2">
                                                <label>
                                                    <input type="radio" value="1" name="is_done" {{ $todo->is_done ? 'checked' : '' }}> Selesai
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" value="0" name="is_done" {{ !$todo->is_done ? 'checked' : '' }}> Belum
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

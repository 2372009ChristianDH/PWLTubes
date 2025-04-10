<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa</title>
    <style>
        /* Global Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f2f5;
        }

        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #f9f9f9;
            outline: none;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            background-color: #fff;
        }

        .submit-btn {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .error-messages {
            color: red;
            margin-bottom: 1rem;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .login-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login Mahasiswa</h2>

        <!-- Tampilkan pesan error jika ada -->
        <div class="error-messages">
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <form method="POST" action="{{ route('login_mahasiswa') }}">
            @csrf

            <!-- NIM Input -->
            <div class="form-group">
                <label for="nrp">NRP:</label>
                <input type="text" id="nrp" name="nrp" value="{{ old('nrp') }}" required>
            </div>

            <!-- Password Input -->
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="submit-btn">Login</button>
            </div>
            
            <!-- Back Button -->
            <div class="form-group">
                <button type="button" class="submit-btn" style="background-color: #6c757d;" onclick="history.back()">Back</button>
            </div>
        </form>
    </div>
</body>

</html>

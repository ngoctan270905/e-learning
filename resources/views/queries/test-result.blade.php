{{-- resources/views/queries/test-result.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả Truy vấn | Laravel Assignment</title>
    {{-- Ví dụ: <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <script src="https://cdn.tailwindcss.com"></script> 
    {{-- HOẶC dùng cách nhúng file đã compile của bạn --}}
    <style>
        /* Tùy chỉnh nhỏ để JSON được cuộn và dễ đọc */
        .json-pre {
            max-height: 70vh;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 border-b pb-2 mb-4">
            Kiểm thử Query Builder & Eloquent
        </h1>
        
        <div class="mb-6 border-l-4 border-indigo-500 pl-4">
            <h2 class="text-2xl font-semibold text-indigo-700 mb-2">
                Kết quả truy vấn: {{ $title ?? 'Không có tiêu đề' }}
            </h2>
            <p class="text-gray-600">
                Tìm thấy: 
                <span class="font-bold text-lg text-green-600">{{ $results->count() }}</span> 
                bản ghi
            </p>
        </div>

        <h3 class="text-xl font-medium text-gray-700 mb-3">Dữ liệu chi tiết (JSON):</h3>

        {{-- Khối hiển thị JSON --}}
        <pre class="json-pre bg-gray-900 text-green-300 p-4 rounded-lg text-sm leading-relaxed overflow-x-auto shadow-inner">
            {{ json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
        </pre>

        <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded text-yellow-800 text-sm">
            <p><strong>URL kiểm tra:</strong> 
                <code>{{ url()->current() }}</code>
            </p>
        </div>
    </div>

</body>
</html>
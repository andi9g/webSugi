<!DOCTYPE html>
<html>
<head>
    <title>{{ $mailData['title'] }}</title>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>
    @php
        $content = explode("\n", $mailData['content']);
    @endphp
    @foreach ($content as $item)
        

        @php
            $lanjut = strpos($item, "LANJUT");
        @endphp
        
        
        @if ($lanjut !== false)
            @php
                str_replace("LANJUT", "", $item);
            @endphp
            <br>
        @endif
        <p>{{ $item }}</p>
        
    @endforeach


    <a href="{{ url('/beranda', []) }}" class="">KUNJUNGI HALAMAN</a>
</body>
</html>
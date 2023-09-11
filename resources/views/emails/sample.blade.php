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
        <p>{{ $item }}</p>

        @php
            $lanjut = strpos($item, "LANJUT");
        @endphp
        
        
        @if ($lanjut == true)
            @php
                str_replace("LANJUT", "", $item);
            @endphp
            <br>
        @endif
        
    @endforeach
</body>
</html>
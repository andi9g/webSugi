<div>
    <div wire:poll.keep-alive>
        @foreach ($diskusi as $item)
            @if ($item->iduser == Auth::user()->id)
                <div class="direct-chat-msg right bg-info p-3 rounded-lg text-white">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-right">{{ $item->user->name }} ({{ $item->user->posisi }})</span>
                        <span class="direct-chat-timestamp float-left text-white">
                            <i>
                                {{ \Carbon\Carbon::parse($item->created_at)->isoFormat("dddd, DD MMMM Y")." ".date("H:i", strtotime($item->created_at)) }}
                            </i>
                        </span>
                    </div>
        
        
                        <div class="">
                           {{ $item->diskusi }}
                        </div>
        
                </div>

            @else
            <div class="direct-chat-msg bg-light p-3 rounded-lg">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">{{ $item->user->name }} ({{ $item->user->posisi }})</span>
                    <span class="direct-chat-timestamp float-right text-dark">
                        <i>
                            {{ \Carbon\Carbon::parse($item->created_at)->isoFormat("dddd, DD MMMM Y")." ".date("H:i", strtotime($item->created_at)) }}
                        </i>
                    </span>
                </div>
    
                
    
                <div class="">
                    {{ $item->diskusi }}
                </div>
    
            </div>
            @endif
        @endforeach
        
        
        <script>
            document.getElementById('chatingan').scrollTo(0, 999999);
        </script>
        
    </div>
</div>

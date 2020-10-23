@if (count($favorite) > 0)
    {{-- お気に入りがあれば表示するページ --}}
    <ul class="list-unstyled">
        @foreach ($favorite as $favorite)
            <li class="media mb-3">
                {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                
                <img class="mr-2 rounded" src="{{ Gravatar::get($favorite->user->email,['size' => 50])}}" alt="">
                
                <div class="media-body">
                    <div>
                        {{--  投稿の所有者のユーザ詳細ページへのリンク --}}
                        {!! link_to_route('users.show', $favorite->user->name, ['user' => $favorite->user->id]) !!}
                        <span class="text-muted">posted at{{ $favorite->created_at }}</span>
                    </div>
                     <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">{!! nl2br(e($favorite->content)) !!}</p>
                    </div>
                    
                    <div>
                        @if (Auth::id() != $favorite->id)
                            {!! Form::open(['route' => ['favorites.unfavorite', $favorite->id], 'method' => 'delete']) !!}
                                {!! Form::submit('UnFavorite', ['class' => 'btn btn-success btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
                            
                    </div>
                    
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    
    
@endif
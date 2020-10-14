<header>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand" hre="/">Microposts</a>
        
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggle-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                {{-- ユーザー登録ページへのリンク --}}
                <li>{!! link_to_route('signup.get','Signup',[],['class' => 'nav-link']) !!}</li>
                
                {{-- ログインページへのリンク --}}
                <li><a href="#" class="nav-link">Login</a></li>
            </ul>
            
        </div>
    </nav>
</header>
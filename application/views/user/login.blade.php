@layout('layout.front')

@section('content')
<!-- Login wrapper begins -->
<div class="loginWrapper">

    <form action="" id="login" method="post">
        <div class="loginPic">
            <span>Autocare BNA Login</span>
            <div class="loginActions">
                <!--div><a href="#" title="Change user" class="logleft flip"></a></div>
                <div><a href="#" title="Forgot password?" class="logright"></a></div-->
            </div>
        </div>

        <input type="text" name="login" placeholder="Confirm your login ID" class="loginEmail" id="loginInput" />
        <input type="password" name="password" placeholder="Password" class="loginPassword" />

        <div class="logControl">
<!--            <div class="memory"><input type="checkbox" checked="checked" class="check" id="remember1" /><label for="remember1">Remember me</label></div>-->
            <input type="submit" name="submit" value="Login" class="buttonM bBlue" />
            <div class="clear"></div>
        </div>
    </form>


    @if (count($errors->messages) > 0)
    <div class="alert-message error">
        <p><strong>Houston!</strong> We have a problem.</p>
    </div>
    <ul>
        @foreach ($errors->all('<li>:message</li>') as $error)
        {{$error}}
        @endforeach
    </ul>
    @endif

</div>
<!-- Login wrapper ends -->

@endsection
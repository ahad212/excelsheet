<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}


body{
    min-height: 100vh;
    padding: 40px 0;
    background-color: #ecedef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Roboto', sans-serif;
}

.card{
    background-color: #fff;
    padding: 30px;
    max-width: 375px;
    width: 100%;
    border-radius: 20px;
    animation: big 0.5s linear;
}

.card h2{
    font-size: 27px;
    margin-bottom: 40px;
}

.inputs{
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
}

.inputs label{
    font-size: 14px;
    margin-bottom: 5px;
}

.inputs input{
    display: block;
    padding: 10px;
    font-size: 16px;
    border-radius: 7px;
    border: 1px solid #464277;
    background-color: #f4f8fb;
    outline: none;
}

.text-right{
    font-size: 16px;
    text-align: right;
    display: block;
    color: #212121;
    margin-bottom: 20px;
}

.btn-login{
    display: block;
    width: 100%;
    height: 40px;
    background-color: #212121;
    color: #fff;
    text-decoration: none;
    text-align: center;
    line-height: 40px;
    border-radius: 7px;
    margin-bottom: 20px;
    transition: 0.3s;
}

.btn-login:hover{
    transform: translateY(-5px);
    box-shadow: 2px 2px 5px rgba(0,0,0,0.4);
}

.text{
    display: block;
    text-align: center;
    color: #888;
    margin-bottom: 20px;
}

.text-long{
    color: #212121;
    margin-bottom: 20px;
}

.social-icons{
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.social-icons a{
    height: 50px;
    width: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: 0.3s;
}

.social-icons a:hover{
    border-radius: 50%;
    transform: translateY(-5px);
    box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
}

.social-icons .google{
    background: #feecea;
    color: #9d4843;
}
.social-icons .twitter{
    background: #ecf4ff;
    color: #34a8f1;
}
.social-icons .facebook{
    background: #edf1fa;
    color: #5e83b0;
}
.social-icons .apple{
    background: #e9e9e9;
    color: #000;
}

.social-icons a i{
    font-size: 20px;
}

@keyframes big {
    from {
        transform: scale(0.7);
      }
    
      to {
        transform: scale(1);
      }
}
.alert{
    height:auto;
    background:rgb(207, 122, 122);
    position:fixed;
    top:0;
    z-index:200px;
}
.success {
    background:rgb(153, 219, 153);
    position:fixed;
    top:10px;
}
.danger {
    background:rgb(199, 123, 123);
    position:fixed;
    top:10px;
}
    </style>
</head>
<body>

    @if($errors->any())
    <div class="alert">
     Form Validation Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

   @if($message = Session('success'))
   <div class="success">
        <strong>{{ $message }}</strong>
   </div>
   @endif
   @if($message = Session('danger'))
   <div class="danger">
        <strong>{{ $message }}</strong>
   </div>
   @endif
    <form action="{{route('login')}}">
        @csrf
    <div class="card">
        <h2>Welcome back</h2>
        <div class="inputs">
            <label>Email</label>
            <input type="email" name="email">
        </div>
        <div class="inputs">
            <label>Password</label>
            <input type="password" name="pass">
        </div>
        <a href="{{route('registration')}}" class="text-right">Create Account?</a>
        <button class="btn-login">Log In</button>
        {{-- <p class="text">OR</p> --}}
        {{-- <p class="long-text">Join Magic Pattern with your social media account</p> --}}
        {{-- <div class="social-icons">
            <a  target="_blank" href="https://youtu.be/xo9W8WQ-QVI" class="social-icon google">
                <i class="fab fa-google"></i>
            </a>
            <a  target="_blank" href="https://youtu.be/xo9W8WQ-QVI" class="social-icon twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a  target="_blank" href="https://youtu.be/xo9W8WQ-QVI" class="social-icon facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a  target="_blank" href="https://youtu.be/xo9W8WQ-QVI" class="social-icon apple">
                <i class="fab fa-apple"></i>
            </a>
        </div> --}}
    </div>
</form>
</body>
</html>
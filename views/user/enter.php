<section class="main-news">
    <form action="" method="POST"  enctype="multipart/form-data"  class="form-signin" id="form-signin">
        <img class="mb-4" src="/docs/4.4/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Войдите (для админа)</h1>
        <div class="form-group">
            <label for="inputEmail" class="sr-only">Логин</label>
            <input autocomplete="off" name="login" type="text" id="inputEmail" class="form-control" placeholder="Логин" required="" autofocus="">
            <div class="valid-feedback">
                Успешно заполнено!
            </div>
            <div class="invalid-feedback">Поля обязательно для заполнения! </div>
        </div>
        <div class="form-group">
            <label for="inputPassword" class="sr-only">Пароль</label>
            <input autocomplete="off"  name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
            <div class="valid-feedback">
                Успешно заполнено!
            </div>
            <div class="invalid-feedback">Поля обязательно для заполнения! </div>
        </div>
         <div class="form-group ">
            <div  id="wrong-authorization" class="alert alert-danger" role="alert">
                A simple danger alert—check it out!
            </div>
         </div>
        
        
        <input type="hidden" name="enter" value="1">
        <button id="form-signin-submit" class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    </form>
</section>

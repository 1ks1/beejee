
<header>
    <a href="/home">Home</a>
</header>

<section>
    <div class="form-group">
    
        <form action="" method="post">
        <?php echo $data['message'] ?><br />
            <input type="text" name="login" placeholder="email" value="<?php echo $data['login'] ?>" /><br />
            <input type="password" placeholder="password" name="password"><br />
            <button type="submit" name="btn_login">Login</button>
        </form>
    </div>
</section>


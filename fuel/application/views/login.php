<?php

/* 
 *  Author Stephen Cotton stephen.cotton@stoneacre.co.uk
 *  Created on 
 */

//fuel_set_var("layout", "login");

?>
<h2 class="login-header"></h2>
<section class="loginform cf">
    <?php //echo validation_errors(); ?>
    <?php echo form_open('login/validate'); ?>
    
        <ul>
            <li>
                <label for="usermail">Email</label>
                <input size="35" type="email" name="usermail" placeholder="yourname@email.com" required value="">
            </li>
            <li>
                <label for="password">Password</label>
                <input size="35" type="password" name="password" placeholder="password" required></li>
            <li>
                <input type="submit" value="Login">
            </li>
        </ul>
    </form>
    <a class="reset" href="password/reset">Forgot password?</a>
</section>
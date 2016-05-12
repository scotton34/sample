<?php

/* 
 *  Author Stephen Cotton stephen.cotton@stoneacre.co.uk
 *  Created on 
 */


?>
<h2 class="login-header"></h2>
<p class="login-message">Reset password</p>
<section class="loginform cf">
    <?php echo validation_errors(); ?>
    <?php echo form_open('password/reset'); ?>
        <ul>
            <li>
                <label for="usermail">Email</label>
                <input size="35" type="email" name="usermail" placeholder="yourname@email.com" required value="">
            </li>
                <input type="submit" value="Reset">
            </li>
        </ul>
    </form>
    <a class="reset" href="/">Back to login?</a>
</section>
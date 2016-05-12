<?php

/* 
 *  Author Stephen Cotton stephen.cotton@stoneacre.co.uk
 *  Created on 
 */

?>
<h2 class="login-header">Intranational Steve's Internal Stationary</h2>
<p class="login-message">Update your password <?=$pageVars['email']?></p>
<section class="loginform cf">
    <?php echo validation_errors(); ?>
    <?php echo form_open('password/update'); ?>
    <input type="hidden" name="usermail" value="<?=$pageVars['email']?>" >
        <ul>
            <li>
                <label for="password">Password</label>
                <input size="35" type="password" name="password" placeholder="password" required></li>
            <li>
            <li>
                <label for="confirmPassword">Confirm Password</label>
                <input size="35" type="password" name="confirmPassword" placeholder="confirm password" required></li>
            <li>
                <input type="submit" value="Update">
            </li>
        </ul>
    </form>
</section>
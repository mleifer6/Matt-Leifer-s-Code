<form action="change_password.php" method="post" id = "password">
    <fieldset>
        <div class="form-group">
            <input autocomplete="off" size = 25 autofocus class="form-control" name="Old" placeholder="Enter Your Old Password" type="password"/>
        </div>
        <div class="form-group">
            <input autocomplete="off" size = 25 autofocus class="form-control" name="New" placeholder="Enter Your New Password" type="password"/>
        </div>
        <div class="form-group">
            <input autocomplete="off" size = 25 autofocus class="form-control" name="Conf" placeholder="Retype Your New Password" type="password"/>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                Change Password
            </button>
        </div>
    </fieldset>
</form>
<?php if($success==1):?>
<p class = "success">Your password has been successfully changed!</p>
<?php endif ?>
<?php if($success==-1):?>
<span class = "error">The old password you entered did not match the one</span>
<br>
<span class = "error">we had on record and your password wasn't updated.</span>
<?php endif ?>
<script>
    var form = document.getElementById("password");
    // onsubmit
    form.onsubmit = function() {
        // validate entries
        if(form.Old.value == '' || form.New.value == ''|| form.Conf.value =='' || (form.New.value!=form.Conf.value) || (form.New.value==form.Old.value))
        {
            var str = " ";
            var error = 0;
            if(form.Old.value == '')
            {
                str = "ERROR: Please fill in the following fields to contine:";
                str = str + " Old Password";
                error++;
            }
            if(form.New.value == '')
            {
                if(error>0)
                {
                    str = str+",";
                }
                else if(error == 0)
                {
                    str = "ERROR: Please fill in the following fields to contine:";
                }
                str = str + " New Password";
                error++;
            }
            if(form.Conf.value =='')
            {
                if(error>0)
                {
                    str = str+", and";
                }
                else if(error == 0)
                {
                    str = "ERROR: Please fill in the following fields to contine:";
                }
                str = str + " Confirmation";
                error++;
            }
            if(error>0)
            {
                str = str +".";
            }
            var str1 = " ";
            if(form.New.value!=form.Conf.value)
            {
                str1 = "Passwords do not match.";
            }
            var str2 = " ";
            if(form.Old.value == form.New.value)
            {
                str2 ="The new password cannot be the same as the old password.";
            }
            document.getElementById("warning").textContent=str+" "+str1+" "+str2;
            return false;
        }
        return true;
    };
</script>
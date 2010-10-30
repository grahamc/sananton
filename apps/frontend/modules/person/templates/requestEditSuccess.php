<h1 class="add_listing">Edit Your Listing</h1>
<p>Enter the email address you used when you registered. You will be emailed an edit link that is good for 30 minutes. No login required!</p>

<form action="<?php echo url_for('@person_edit_request'); ?>" method="post">
<div class="generate_edit_form">
<p>
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email" />
</p>

<p class="submit">
    <input type="submit" name="commit" value="Submit" />
</p>
</div>
</form>
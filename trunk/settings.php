<h2>Monitor Adblock</h2>
<div class="wrap">
    <form action="options.php" method="post" enctype="multipart/form-data">

        <?php settings_fields('adblock_options')?>
        Your Message: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="adblock_message" style="width:300px" value="<?php echo $m;?>">
        <br>
        <br> Image displayed: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <input type="text" name="adblock_image_url" style="width:300px; margin-left:-3px" placeholder="Enter Image Url" <?php if (!empty($image)) echo "value = '$image'";?>>
        <br>
        <br>
        <input type="submit" name="save_image" class="button-primary" value="upload">
    </form>
</div>

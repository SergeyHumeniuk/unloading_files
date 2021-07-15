<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
    <form action="" method="post" id="uploadfile" enctype="multipart/form-data">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="filename" id="floatingInput" placeholder="Назва файлу" value=''>

        </div>

        <input type="file" name="file">
        <button type="submit" data-toggle="tooltip" class="btn btn-primary" data-original-title="<?php echo $strings['word_save_settings']; ?>"><i class="fa fa-save"></i></button>
    </form>
    <hr>
    <h1>Файли в наявності</h1>
    <div class="group-files">
        <ul>
            <? if (is_array($all_files) && !empty($all_files)) {
                foreach ($all_files as $key => $value) {
                    echo "<li class='file-info'><span>" . $value['name'] . "</span>  <span>" . $value['date_created'] . "</span><span><form action='' method='post'  enctype='multipart/form-data'><input type='hidden' name='delete_file' value='" . $value['id'] . "'><input type='hidden' name='file_url' value='" . $value['file'] . "'><button type='submit'  class='btn btn-primary' >Видалити</button></form></span></li>";
                    //var_dump($value);
                }
            } else {
                echo 'No files';
            }
            ?>
        </ul>
    </div>

</div>
<?php echo $footer; ?>
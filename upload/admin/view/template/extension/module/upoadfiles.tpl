<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">


    <div class="spin-settings-wrapper">

        <div class="spin-tabs">
            <a class="spin-tablink active" target-tabcontent="upload-files-display"><?php echo $strings['word_display_users']; ?></a>
            <div class="pull-left submit-wrapper">
                <button type="submit" form="spin-win-form" data-toggle="tooltip" class="btn btn-primary" data-original-title="<?php echo $strings['word_save_settings']; ?>"><i class="fa fa-save"></i></button>
            </div>

        </div>
    </div>

    <!-- Display & Time Settings Tab Content -->
    <form action="" method="post" name="spin-win-form" id="spin-win-form">
        <div class="display-settings-tab spin-settings-tabcontent" id="upload-files">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $strings['word_wheel_display_settings']; ?></h3>
                </div>
                <div class="panel-body">
                    <div class="wheel-display-settings settings-section">
                        <?php var_dump($all_files); ?>
                    </div>
                </div>
            </div>
        </div>

    </form>



</div>
<?php echo $footer; ?>
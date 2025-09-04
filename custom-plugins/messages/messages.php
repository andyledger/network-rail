<?php

class message{
    /**
     * [json_admin_notice__success description]
     * @return [type] [description]
     */
    public static function json_admin_notice__success() {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><strong>json file successfully created</strong></p>
        </div>
        <?php
    }

    public static function wrong_notice__error() {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><strong>Something went wrong</strong></p>
        </div>
        <?php
    }

    public static function custom_notice__success($message) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><strong><?php echo $message ?></strong></p>
        </div>
        <?php
    }

    public static function custom_notice__error($message) {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><strong><?php echo $message ?></strong></p>
        </div>
        <?php
    }
}

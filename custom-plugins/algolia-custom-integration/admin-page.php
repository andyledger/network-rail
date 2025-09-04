<?php

namespace AlgoliaCustomPlugin;

class Page
{
    public function __construct()
    {
        add_action('admin_menu', [ $this, 'createMenu' ]);
        add_action('admin_init', [ $this, 'registerSetting' ]);
    }

    public function createMenu()
    {
        add_options_page(
            'Algolia',
            'Algolia',
            'manage_options',
            'algolia',
            [
                $this,
                'pageTemplate'
            ]
        );
    }

    public function registerSetting(){
        register_setting( 'algolia_settings', 'algolia_applicationID' );
        register_setting( 'algolia_settings', 'algolia_searchApiKey' );
        register_setting( 'algolia_settings', 'algolia_writeApiKey' );
        register_setting( 'algolia_reindex_settings', 'algolia_postTypes' );
        register_setting( 'algolia_reindex_settings', 'algolia_excludeIds' );
        register_setting( 'algolia_reindex_settings', 'algolia_indexName' );
    }

    public function pageTemplate()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        ?>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Algolia settings</h1>

                    <form method="POST" action="options.php" class="mb-3">
                        <?php settings_fields( 'algolia_settings' ); ?>

                        <div class="form-group">
                           <label>Application ID:</label>

                           <input type="text" class="form-control" name="algolia_applicationID" value="<?php echo get_option('algolia_applicationID'); ?>">
                        </div>

                        <div class="form-group">
                           <label>Search API Key:</label>

                           <input type="text" class="form-control" name="algolia_searchApiKey" value="<?php echo get_option('algolia_searchApiKey'); ?>">
                        </div>

                        <div class="form-group">
                           <label>Write API Key:</label>

                           <input type="text" class="form-control" name="algolia_writeApiKey" value="<?php echo get_option('algolia_writeApiKey'); ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                    <hr>

                    <h3>Reindex settings</h3>

                    <form method="POST" action="options.php" class="mb-3">
                        <?php settings_fields( 'algolia_reindex_settings' ); ?>

                        <div class="form-group">
                           <label>Index name:</label>

                           <input type="text" class="form-control" name="algolia_indexName" value="<?php echo get_option('algolia_indexName'); ?>">

                            <small id="emailHelp" class="form-text text-muted">The index in Algolia for seaching</small>
                        </div>

                        <div class="form-group">
                           <label>Post types:</label>

                           <input type="text" class="form-control" name="algolia_postTypes" value="<?php echo get_option('algolia_postTypes'); ?>">

                            <small id="emailHelp" class="form-text text-muted">Post types separated by comma (post, feeds, page)</small>
                        </div>

                        <div class="form-group">
                           <label>Exclude from index:</label>

                           <input type="text" class="form-control" name="algolia_excludeIds" value="<?php echo get_option('algolia_excludeIds'); ?>">

                            <small id="emailHelp" class="form-text text-muted">Ids separated by comma (45, 345, 435324)</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                    <p>
                        Enter a new name to create a new index or the same to reindex.
                    </p>

                    <form method="POST" action="options-general.php?page=algolia" class="mb-3 form-inline">
                        <input type="text" class="form-control mr-2" name="reindex" value="" placeholder="index name">

                        <button type="submit" class="btn btn-primary">Reindex</button>
                    </form>
                </div>
            </div>
        </div>
        <?php

        if( isset( $_POST['reindex'] ) ) {
            $actions = new \AlgoliaCustomPlugin\Actions;
            $actions->reindex($_POST['reindex']);
        }
    }
}

new Page;

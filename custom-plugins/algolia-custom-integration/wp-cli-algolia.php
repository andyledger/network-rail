<?php

if (! (defined('WP_CLI') && WP_CLI)) {
    return;
}

class Algolia_Command {
    public function hello( $args, $assoc_args ) {
        WP_CLI::success('Algolia is correctly loaded 🎉');
    }

    public function reindex( $args, $assoc_args ) {
        global $algolia;

        $name = isset($assoc_args['name']) ? $assoc_args['name'] : WP_CLI::error( 'the index needs a name. Use --name="name" option.' );

        $index = $algolia->initIndex($name);

        $index->clearObjects()->wait();

        $post_type = explode(',', get_option('algolia_postTypes'));

        $paged = 1;
        $count = 0;
        do {
            $posts = new WP_Query([
                'posts_per_page' => 10,
                'paged' => $paged,
                'post_type' => $post_type,
                'post_status' => 'publish'
            ]);

            if (! $posts->have_posts()) {
                break;
            }

            $records = [];
            foreach ($posts->posts as $post) {
                if ($assoc_args['verbose']) {
                    WP_CLI::line('Serializing ['.$post->post_title.']');
                }

                $record = (array) apply_filters('item_to_record', $post);

                if (! isset($record['objectID'])) {
                    $record['objectID'] = implode('#', [$post->post_type, $post->ID]);
                }

                $records[] = $record;
                $count++;
            }

           if ($assoc_args['verbose']) {
               WP_CLI::line('Sending batch');
           }
            $index->saveObjects($records);

            $paged++;

        } while ($paged == 2);

        $index->setSettings([
          'replicas' => [
            $name.'_date_desc'
          ]
        ]);

        $replicaIndex = $algolia->initIndex($name.'_date_desc');

        $replicaIndex->setSettings([
          'ranking' => [
            'desc(post_date_timestamp)'
          ]
        ]);

        WP_CLI::success("$count posts indexed in Algolia");
    }
}

WP_CLI::add_command( 'algolia', 'Algolia_Command' );


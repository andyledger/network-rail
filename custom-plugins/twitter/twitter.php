<?php 
/**
 * Provides the latest Tweet array to use in our templates
 * Checks for cached version of the latest tweet
 * if it doesn't exist creates one.
 */
function networkrail_get_latest_tweet( $channel, $hashtags ) {

  $pageID = get_the_ID();
  $tweet_transient = 'latest_tweet_for_page_'.$pageID;
  $latest_tweet = get_transient( $tweet_transient );

  if ( false === $latest_tweet ){
    $response = networkrail_get_twitter_response( $channel, $hashtags ); // prepare response
    $latest_tweet = networkrail_get_latest_tweet_content($response); // latest tweet array 
    set_transient( $tweet_transient, $latest_tweet, 60*15 );
  }

  return $latest_tweet;
}

/**
 * Deletes transient on post/page update
 * To provide the Tweet content up to date when settings are saved
 */
function delete_latest_tweet_transient( $post_id ) {

  // If this is just a revision, don't delete transient.
  if ( wp_is_post_revision( $post_id ) )
    return;

  $pageID = get_the_ID( $post_id );
  $tweet_transient = 'latest_tweet_for_page_'.$pageID;
  delete_transient( $tweet_transient );
}
add_action( 'save_post', 'delete_latest_tweet_transient' );


/**
 * Formats the latest Tweet (plain text -> HTML)
 * Provides an error message when we don't have response
 * @param  [array or string] Twitter API Response
 * @return [array] Array with latest tweet details
 */
function networkrail_get_latest_tweet_content($response){
  
  $latest_tweet = array();

  // get the proper latest Tweet content
  if ( isset( $response['statuses'][0] ) ){
    $tweet = $response['statuses'][0];
    $latest_tweet['content'] = networkrail_tweet_to_html( $tweet );
    $date = new DateTime( $tweet['created_at'] ); 
  } 
  // Just in case response still is null = Twitter API failed.
  else {
    $latest_tweet['content'] = 'An error occurred while trying to connect to Twitter. Please try again later.';
    $date = new DateTime();
  }
  $date = $date->format("j M Y");
  $latest_tweet['date'] = $date;

  return $latest_tweet;
}


/**
 * Fallback to default channel for empty response
 * ie: wrong channel name or hasthag that doesn't exist
 * @param  [string] Twitter user screen_name
 * @param  [array] Array of hashtags
 * @return [array] valid response from Twitter API 
 */
function networkrail_get_twitter_response( $channel = 'networkail', $hashtags = null ){
  
  // Try to get response with channel and hashtags
  $response = networkrail_prepare_twitter_response( $channel, $hashtags );

  // If response doesn't contain tweet try without hashtags and grab latest tweet from the channel
  if ( ! $response ) {
    $response = networkrail_prepare_twitter_response( $channel );

    // If we still have empty response it means that the channel name is wrong: roll back to networkrail latest tweet
    if( ! $response ) {
      $response = networkrail_prepare_twitter_response( 'networkrail' );
    }
  }
    
  return $response;
}


/**
 * Prepares the response from Twitter API that contains the latest tweet 
 * @param  [string] Twitter user screen_name
 * @param  [array] Array of hashtags
 * @return [array] response from Twitter API 
 */
function networkrail_prepare_twitter_response( $channel = 'networkail', $hashtags = null ){
  $url = 'https://api.twitter.com/1.1/search/tweets.json';
  $getfield = networkrail_prepare_twitter_query( $channel, $hashtags );
  $requestMethod = 'GET';
  $twitter = new TwitterAPIExchange(
    [
      'oauth_access_token' => '575802666-2IHZjqhMSFG3dvgXOqi47QpKQpOnZgAS4p0hqoei',
      'oauth_access_token_secret' => 'e8ioPr7oFpE6nyqe7uu4Ff7ZiTHZUX59gqlE7u8b8qL7o',
      'consumer_key' => 'bOR1ueCFWZVzXQ1FGM6GNZtal',
      'consumer_secret' => '3IPdi7svJybkkNjdAbbHKziEQLsVyp94BcHqR9Ew5sWQZ3rPkH'
    ]
  );
  $response =  $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
  $response = json_decode( $response, true );
  if ( ! isset( $response['statuses'][0] ) ) {
    $response = false;
  }
  return $response;
}

/**
 * Generates the query for getting Twitter API response
 * @param  [string] Twitter user screen_name
 * @param  [array] Array of hashtags
 * @return [string] query for Twitter API 
 */
function networkrail_prepare_twitter_query( $channel='networkail', $hashtags ){

  $query = '?q=from:'.$channel;

  if( $hashtags ) {
    $query .= '+';
    $items = array();
    foreach( $hashtags as $h ) {
      $items[] = '#'.$h['sb_hashtag'];
    }
    $hashtag_query = implode("+OR+", $items);
    $query .= $hashtag_query;
  }

  $query .= '+exclude:replies+exclude:retweets&result_type=recent&count=1';

  return $query;
}


/**
 * Converts the text string from Twitter 1.1 API to HTML
 * @param  [array] $tweet Tweet array returned from Twitter API
 * @return [string] Tweet with anchors for media, hashtags and urls.
 */
function networkrail_tweet_to_html( $tweet ){

  $tweetText = $tweet['text'];
    
  @$urls = $tweet['entities']['urls'];

  if ( ! empty( $urls ) ) {
    foreach ( $urls as $u ){
      $old_url = $u['url'];
      $temp = '<a href="'.$u['expanded_url'].'" target="_blank">'.$u['display_url'].'</a>';
      $tweetText = str_replace( $old_url, $temp, $tweetText );
    }
  }

  @$media = $tweet['entities']['media'];
    
  if ( ! empty( $media ) ) {
    foreach ($media as $m){
      $old_media = $m['url'];
      $temp = '<a href="'.$m['url'].'" target="_blank">'.$m['url'].'</a>';
      $tweetText = str_replace( $old_media, $temp, $tweetText );
    }
  }

  $tweetText = preg_replace('#@(\w+)#', '<a href="http://twitter.com/$1" target="_blank">$0</a>', $tweetText);
  $tweetText = preg_replace('/#(\w+)/', '<a href="https://twitter.com/hashtag/$1" target="_blank">$0</a>', $tweetText);

  return $tweetText;
}
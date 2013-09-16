    $oTwitter = new TwitterOAuth 
    ('YOUR_TWITTER_APP_CONSUMER_KEY',
     'YOUR_TWITTER_APP_CONSUMER_SECRET',
     'YOUR_TWITTER_APP_OAUTH_TOKEN',
     'YOUR_TWITTER_APP_OAUTH_SECRET');
     
//FULL FOLLOWERS ARRAY WITH CURSOR ( FOLLOWERS > 5000)
    $e = 0;
    $cursor = -1;
    $full_followers = array();
    do {
        //SET UP THE URL
      $follows = $oTwitter->get("followers/ids.json?screen_name=USERNAMEHERE&cursor=".$cursor);
      $foll_array = (array)$follows;

      foreach ($foll_array['ids'] as $key => $val) {

            $full_followers[$e] = $val;
            $e++; 
      }
           $cursor = $follows->next_cursor;

      } while ($cursor > 0);
echo "Number of followers:" .$e. "<br /><br />";

//FULL FRIEND ARRAY WITH CURSOR (FOLLOWING > 5000)
    $e = 0;
    $cursor = -1;
    $full_friends = array();
    do {

      $follow = $oTwitter->get("friends/ids.json?screen_name=USERNAMEHERE&cursor=".$cursor);
      $foll_array = (array)$follow;

      foreach ($foll_array['ids'] as $key => $val) {

            $full_friends[$e] = $val;
            $e++;
      }
          $cursor = $follow->next_cursor;
    
    } while ($cursor > 0);
    echo "Number of following:" .$e. "<br /><br />";

//IF I AM FOLLOWING USER AND HE IS NOT FOLLOWING ME BACK, I UNFOLLOW HIM
$index=0;
foreach( $full_friends as $iFollow )
{
$isFollowing = in_array( $iFollow, $full_followers );
 
echo $index .":"."$iFollow: ".( $isFollowing ? 'OK' : '!!!' )."<br/>";

 if( !$isFollowing )
    {
    $parameters = array( 'user_id' => $isFollowing );
    $status = $oTwitter->post('friendships/destroy', $parameters);
    } if ($index++ === 999) break;
}
echo "<br /><br />";

//IF USER IS FOLLOWING ME AND I AM NOT, I FOLLOW
$index=0;
foreach( $full_followers as $heFollows )
{
$amFollowing = in_array( $heFollows, $full_friends );
 
echo $index .":"."$heFollows: ".( $amFollowing ? 'OK' : '!!!' )."<br/>";

 if( !$amFollowing )
    {
    $parameters = array( 'user_id' => $amFollowing );
    $status = $oTwitter->post('friendships/create', $parameters);
    } if ($index++ === 999) break;
}
 
 
?>

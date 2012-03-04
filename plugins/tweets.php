<h3>My Tweets</h3>
<style type="text/css">
  div.oneTweet {
     margin-top: 5px;
  }
  div.oneTweetDate {
    color: silver;
    font-style: italic;
  }
  div.moreTweets {
    margin-top: 5px;
    text-align: right;
  }
</style>
<?php
	      $twitterUsername = 'honzab';
        $tweetsCount = 5; 
	      
	      function file_get_contents_curl($url, $cachelifeTime=120) {
	      	$cacheFile = realpath(dirname(__FILE__)).'/tweets.xml';
	      	if (is_file($cacheFile) && (time()-filemtime($cacheFile) < $cachelifeTime)) {
	      		return file_get_contents($cacheFile);
	      	}
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_HEADER, 0);         //nevypisovat hlavičky
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //výsledek jako string 
          curl_setopt($ch, CURLOPT_URL, $url);         //nastavení url
          $data = curl_exec($ch);
          curl_close($ch);
		  file_put_contents($cacheFile, $data);
          return $data;
        }
        
function twitterLinkify($text) {
  $returnText = preg_replace("/[A-z]+\:\/\/[^<>]+[A-z0-9]+\/?/", "<a href=\"\\0\">\\0</a>", $text);
  $returnText = preg_replace("/\@([A-z0-9\_]+)/", "<a href=\"http://twitter.com/\\1\">@\\1</a>", $returnText);
  $returnText = preg_replace("/\#([A-z0-9\_]+)/", "<a href=\"http://twitter.com/#!/search/\\1\">#\\1</a>", $returnText);
	return $returnText;
}
	      
$tweetXml = file_get_contents_curl('http://twitter.com/statuses/user_timeline/'.$twitterUsername.'.xml?count='.$tweetsCount, 240);
$xml = new SimpleXMLElement($tweetXml);
foreach ($xml as $tweet) {
    $date = strtotime($tweet->created_at);
    $tweetHtml = '<div class="oneTweet"><div class="oneTweetDate">'.date('d.m.Y H:i', $date).'</div>'.twitterLinkify($tweet->text).'</div>';
    echo $tweetHtml;
}
     ?>
<div class="moreTweets">
  <a href="http://twitter.com/<?php echo $twitterUsername; ?>">... more</a>
</div>
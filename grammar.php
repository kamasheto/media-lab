<?php
header ('Content-Type:text/xml');  
echo '<?xml version="1.0" encoding="UTF-8"?>'; 

mysql_connect("localhost", "root", "");
mysql_select_db("advlab");

// fix _REQUEST first

$attrs = explode('|', $_SERVER['QUERY_STRING']);
foreach ($attrs as $attr) {
	list($k, $v) = explode('=', $attr);
	$_REQUEST[$k] = $v;
}


switch ($_REQUEST['g']) {
	case 'home': 
		$data = array(
			array('item' => 'order',
					'dtmf' => 1,
					'tags' => array(
						'choice' => 'order',
						'next' => '#food_menu',
						)),
			array('item' => 'service',
					'dtmf' => 2,
					'tags' => array(
						'choice' => 'service',
						'next' => '#supportForm',
						)),
			array('item' => 'track',
					'dtmf' => 3,
					'tags' => array(
						'choice' => 'track',
						'next' => '#trackForm',
						)));
?>

<grammar mode="<?php echo $_REQUEST['mode']; ?>" root="top" version="1.0" xml:lang="en-US" xmlns="http://www.w3.org/2001/06/grammar">
  <rule id="top" scope="public">
    <one-of>
<?php
foreach ($data as $item) { ?>
		<item>
	<?php if ($_REQUEST['mode'] == 'dtmf') : ?>
			<item><?php echo $item['dtmf']; ?></item>
	<?php else: ?>
        	<item><?php echo $item['item']; ?></item>
	<?php endif; ?>
			<tag><?php foreach ($item['tags'] as $k => $v) echo $k . "='$v'; "; ?></tag>
		</item>
	<?php } ?>
    </one-of>
  </rule>
</grammar>
<?php
		die;

	case 'track':
		function to_words($arr) {
			$strs = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine");	
			foreach ($arr as $k => $v) {
				$arr[$k] = $strs[$v];
			}
			return $arr;
		}
		$data = array();
		$q = mysql_query("SELECT * FROM tracking_order");
		while ($r = mysql_fetch_object($q)) {
			// add item to $data
			$data[] = array(
					'dtmf' => str_split($r->id),
					'voice' => to_words(str_split($r->id)),
					'message' => $r->message
				);
		}

?>

<grammar mode="<?php echo $_REQUEST['mode']; ?>" root="top" version="1.0" xml:lang="en-US" xmlns="http://www.w3.org/2001/06/grammar">
	<rule id="top" scope="public">
		<one-of>
			<?php foreach ($data as $order): ?>
			<item>
				<?php foreach ($order[$_REQUEST['mode']] as $v) :?>
				<item><?php echo $v; ?></item>
				<?php endforeach; ?>
				<tag>tracking_message='<?php echo $order['message']; ?>';</tag>
			</item>
			<?php endforeach; ?>
		</one-of>
	</rule>
</grammar>


<?php
		die;
}
?>
<?php
session_start();

//iz GET array unutar url dohvaća kartu iz baze i prikazuje njene podatke na način da u bazi piše gdje se json file nalazi, a onda ga čita i ispisuje na stranici
$opened_card_id = $_GET['card_id'];
$card_found = false;

include("scripts/db_connect.php");

$get_card_sql = "SELECT * FROM all_cards WHERE card_id=$opened_card_id";
$result = mysqli_query($conn, $get_card_sql);

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);


    //read data from json and display
    $json_file = file_get_contents("json_cards/test_card". $opened_card_id . ".json");
    $json_file_data = json_decode($json_file,1);

    $card_found = true;
}
else{
    $card_found = false;
}

if($card_found && isset($_GET['local_json'])){
    download_json_file_locally();
}

function download_json_file_locally(){
    $filename = 'json_cards/test_card' . $_GET['card_id'] .'.json';
    echo $filename;

    if (file_exists($filename)) {
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($filename));
	    readfile($filename);
	exit;
}
}

?>


<!DOCTYPE html>
<html lang="en">

<?php include('header.php'); ?>
<?php if($card_found){ ?>
<section class="container">
    <h1 class="text-center">Opened Card: <?php echo $row['card_title'];?></h1>
    <h2 class="text-center">Made by: <?php echo $row['card_author'];?></h2>  
    <div class="row">
        <div class="col">
            <img src="res/placeholder/mokey_mokey.png" alt="Generated image through canvas">
        </div>

        <div class="col">
        
            <div class="m-3 p-2">
                <label for="card_title">Title</label>
                <input type="text" name="card_title" id="card_title" value="<?php echo $json_file_data['card_title']; ?>" disabled/>
            </div>
            <div class="m-3 p-2">
                    <label for="card_ATK">ATK</label>
                    <input type="text" name="card_ATK" id="card_ATK" value="<?php echo $json_file_data['card_ATK']; ?>" disabled/>

                    <label for="card_DEF">DEF</label>
                    <input type="text" name="card_DEF" id="card_DEF" value="<?php echo $json_file_data['card_DEF']; ?>" disabled/>
            </div>
            <div class="m-3 p-2">
                    <label for="card_serial_number">Serial Number</label>
                    <input type="number" name="card_serial_number" id="card_serial_number" value="<?php echo $json_file_data['card_serial_number']; ?>" disabled/>

                    <label for="card_set_id">Set</label>
                    <input type="text" name="card_set_id" id="card_set_id" value="<?php echo $json_file_data['card_set_id']; ?>" disabled/>
            </div>
            <div class="m-3 p-2">
                <p><label for="card_text">Card TEXT</label></p>
                <textarea  name="card_text" id="card_text" cols="50" rows="4" disabled><?php echo $json_file_data['card_text']; ?></textarea>
            </div>
            <div class="m-3 p-2">
                <label for="card_monster_type">Monster Type</label>
                <input type="text" name="card_monster_type" id="card_monster_type" value="<?php echo $json_file_data['card_monster_type']; ?>" disabled/>
            </div>

            <div class="m-3 p-2">
                <label for="card_level_rank">Level/Rank</label>
                <select name="card_level_rank" id="card_level_rank" disabled>
                    <option value="star0">0</option>
                    <option value="star1">1</option>
                    <option value="star2">2</option>
                    <option value="star3">3</option>
                    <option value="star4" selected>4</option>
                    <option value="star5">5</option>
                    <option value="star6">6</option>
                    <option value="star7">7</option>
                    <option value="star8">8</option>
                    <option value="star9">9</option>
                    <option value="star10">10</option>
                    <option value="star11">11</option>
                    <option value="star12">12</option>
                </select>

                <label for="card_attribute">Attribute</label>
                <select name="card_attribute" id="card_attribute" disabled>
                    <option value="dark" selected>Dark</option>
                    <option value="divine">Divine</option>
                    <option value="earth">Earth</option>
                    <option value="fire">Fire</option>
                    <option value="light">Light</option>
                    <option value="water">Water</option>
                    <option value="wind">Wind</option>      
                </select>
            </div>
            <div class="m-3 p-2">
                <label for="card_card">Card Type</label>
                <select name="card_card" id="card_card" disabled>
                    <option value="monster" selected>Monster</option>
                    <option value="pendulum">Pendulum</option>
                    <option value="spell">Spell</option>
                    <option value="trap">Trap</option>   
                </select>

                <label for="card_sub_card">Card Sub-Type</label>
                <select name="card_sub_card" id="card_sub_card" disabled>
                    <option value="normal" selected>Normal</option>
                    <option value="continuous">Continuous</option>
                    <option value="equip">Equip</option>
                    <option value="field">Field</option>
                    <option value="quick_play">Quick-Play</option>
                    <option value="ritual">Ritual</option>
                </select>

                <select name="card_sub_card" id="card_sub_card" disabled>
                    <option value="normal" selected>Normal</option>
                    <option value="continuous">Continuous</option>
                    <option value="counter">Counter</option>
                </select>

                <select name="card_sub_card" id="card_sub_card" disabled>
                    <option value="normal" selected>Normal</option>
                    <option value="effect">Effect</option>
                    <option value="ritual">Ritual</option>
                    <option value="fusion">Fusion</option>
                    <option value="synchro">Synchro</option> 
                    <option value="xyz">XYZ</option>       
                    <option value="link">Link</option>   
                </select>

            </div>
            <div class="m-3 p-2">
                <p>Is Pendulum or Link</p>
                <label for="card_is_none">None</label>
                <input type="radio" name="card_pendulum_link" id="card_is_none" value="card_is_none" checked disabled>
                <label for="card_is_pendulum">Pendulum</label>
                <input type="radio" name="card_pendulum_link" id="card_is_pendulum" value="card_is_pendulum" disabled>
                <label for="card_is_link">Link</label>
                <input type="radio" name="card_pendulum_link" id="card_is_link" value="card_is_link" disabled>
            </div>
            <div class="m-3 p-2">
                <label for="card_link_rating">Link Rating</label>
                <input type="number" name="card_link_rating" id="card_link_rating" value="<?php echo $json_file_data['card_link_rating']; ?>" disabled/>

                <label for="card_pscale_left">Left Scale</label>
                <input type="number" name="card_pscale_left" id="card_pscale_left" value="<?php echo $json_file_data['card_pscale_left']; ?>" disabled/>

                <label for="card_pscale_right">Right Scale</label>
                <input type="number" name="card_pscale_right" id="card_pscale_right" value="<?php echo $json_file_data['card_pscale_right']; ?>" disabled/>
            </div>
            <form enctype="multipart/form-data" action="http://localhost/UltraCardMakerXML/openCard.php?card_id=<?php echo $opened_card_id;?>" method="get">
            <div class="m-3 p-2">
                <div class="m-3">
                    <input type="submit" name="local_json" value="DOWNLOAD LOCAL JSON" class="btn btn-info">
                    <input type="number" name="card_id" value="<?php echo $opened_card_id ?>" hidden/>
                </div>
            </div>

            

        </form>
    </div>
</section>
<?php }else{?>
    <div class="container text-center">
        <p>Sorry, we weren't able to find the card you were looking for.</p>
        <p>No such card exists with Card id: <?php echo $_GET['card_id']; ?></p>
    </div>
<?php } ?>
<?php include('footer.php'); ?>
    
</body>
</html>
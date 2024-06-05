<?php

session_start();

include("scripts/db_connect.php");

$cardData = $_POST;
if(isset($_POST['new_card'])){
    if(isset($_SESSION['card_id'])){
        new_card_creation($conn,$cardData);
    }
}

//kad je logout i želimo kreirati kartu
if(!isset($_SESSION['card_id'])){
    new_card_creation($conn,$cardData);
}

$card_id = $_SESSION['card_id'];

//na refresh ostaju podaci forme
if(isset($_POST['submit'])){
    $card_title = $cardData['card_title'];
    $card_text = $cardData['card_text'];
    $card_ATK = $cardData['card_ATK'];
    $card_DEF = $cardData['card_DEF'];
    $card_serial_number = $cardData['card_serial_number'];
    $card_set_id = $cardData['card_set_id'];
    $card_attribute = $cardData['card_attribute'];
    $card_monster_type = $cardData['card_monster_type'];
    $card_sub_card = $cardData['card_sub_card'];
    $card_card = $cardData['card_text'];
    $card_level_rank = $cardData['card_level_rank'];
    $card_pendulum_link = $cardData['card_pendulum_link'];
    $card_link_rating = $cardData['card_link_rating'];
    $card_pscale_left = $cardData['card_pscale_left'];
    $card_pscale_right = $cardData['card_pscale_right'];
}else{
    $card_title = "";
    $card_text = "";
    $card_ATK = "";
    $card_DEF = "";
    $card_serial_number = "";
    $card_set_id = "";
    $card_attribute = "";
    $card_monster_type = "";
    $card_sub_card = "";
    $card_card = "";
    $card_level_rank = "";
    $card_pendulum_link = "";
    $card_link_rating = "";
    $card_pscale_left = "";
    $card_pscale_right = "";
}

//sprema na server json file
function save_server_json($jsonCard, $card_id, $conn){

    $json_path = "json_cards/test_card" . $card_id . ".json";
    $card_title =  isset($_POST['card_title']) != "" ? $_POST['card_title'] : "Not YET entered";

    $sql = "UPDATE all_cards SET card_title = '$card_title', card_data = '$json_path' WHERE card_id = '$card_id'";
    mysqli_query($conn,$sql);

    file_put_contents($json_path, $jsonCard);

}


//stvara novi zapis u bazi i samim time kreira novu kartu
function new_card_creation($conn, $cardData){
    $author = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest User";
    $jsonCard = generate_json_file($cardData);
    

    $insert_sql = "INSERT INTO all_cards(card_title, card_author) VALUES ('Not YET entered','$author')";
    $result = mysqli_query($conn, $insert_sql);

    if($result){
        $card_id = mysqli_insert_id($conn);
        save_server_json($jsonCard, $card_id, $conn);
        echo "Succesfully added new card with id = $card_id";
        $_SESSION['card_id'] = $card_id;
        return;
    }
    else{
        echo "Query error: " . mysqli_error($conn);
    }
    
    
}


//generira json file
function generate_json_file($cardData){
    $card_author = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest User";
    $arrayCard = ($_SERVER['REQUEST_METHOD'] === 'POST') ? array(
        'card_title' => $cardData['card_title'],
        'card_text' => $cardData['card_text'],
        'card_ATK' => $cardData['card_ATK'],
        'card_DEF' => $cardData['card_DEF'],
        'card_serial_number' => $cardData['card_serial_number'],
        'card_set_id' => $cardData['card_set_id'],
        'card_attribute' => $cardData['card_attribute'],
        'card_monster_type' => $cardData['card_monster_type'],
        'card_sub_card' => $cardData['card_sub_card'],
        'card_card' => $cardData['card_text'],
        'card_level_rank' => $cardData['card_level_rank'],
        'card_pendulum_link' => $cardData['card_pendulum_link'],
        'card_link_rating' => $cardData['card_link_rating'],
        'card_pscale_left' => $cardData['card_pscale_left'],
        'card_pscale_right' => $cardData['card_pscale_right'],
        'card_author' => $card_author
    ): array('card_author' => $card_author);

    //generate JSON file
    $jsonCard = json_encode($arrayCard, JSON_PRETTY_PRINT);

    return $jsonCard;
}

//download file na računalo kao user sa servera
function download_json_file_locally($cardData){
    generate_json_file($cardData);
    $filename = 'json_cards/test_card' . $_SESSION['card_id'] .'.json';
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



//spremi na server JSON 
if(isset($_POST['submit'])){
    $jsonCard = generate_json_file($cardData);

    save_server_json($jsonCard, $card_id,$conn);
}

//preuzmi JSON sa servera
if(isset($_POST['local_json'])){
    download_json_file_locally($cardData);
}

?>


<?php 
?>

<!DOCTYPE html>
<html lang="en">

<?php include('header.php'); ?>

<section class="container">
    <h1 class="text-center">Create New Card</h1>
    <div class="row">
        <div class="col">
            <img src="res/placeholder/mokey_mokey.png" alt="Generated image through canvas">
        </div>

        <div class="col">
        <form enctype="multipart/form-data" action="cardBuilder.php" method="post">
            <div class="m-3 p-2">
                <label for="card_title">Title</label>
                <input type="text" name="card_title" id="card_title" value="<?php if(isset($card_title)){echo $card_title ;} ?>"/>
            </div>
            <div class="m-3 p-2">
                    <label for="card_ATK">ATK</label>
                    <input type="text" name="card_ATK" id="card_ATK" value="<?php if(isset($card_ATK)){echo $card_ATK ;} ?>"/>

                    <label for="card_DEF">DEF</label>
                    <input type="text" name="card_DEF" id="card_DEF" value="<?php if(isset($card_DEF)){echo $card_DEF ;} ?>"/>
            </div>
            <div class="m-3 p-2">
                    <label for="card_serial_number">Serial Number</label>
                    <input type="number" name="card_serial_number" id="card_serial_number" value="<?php if(isset($card_serial_number)){echo $card_serial_number ;} ?>"/>

                    <label for="card_set_id">Set</label>
                    <input type="text" name="card_set_id" id="card_set_id" value="<?php if(isset($card_set_id)){echo $card_set_id ;} ?>"/>
            </div>
            <div class="m-3 p-2">
                <p><label for="card_text">Card TEXT</label></p>
                <textarea  name="card_text" id="card_text" cols="50" rows="4" value="<?php if(isset($card_text)){echo $card_text ;} ?>"></textarea>
            </div>
            <div class="m-3 p-2">
                <label for="card_monster_type">Monster Type</label>
                <input type="text" name="card_monster_type" id="card_monster_type" value="<?php if(isset($card_monster_type)){echo $card_monster_type ;} ?>"/>
            </div>
            <div class="m-3 p-2">
                <label for="card_image">Card Image</label>
                <input type="file" name="card_image" id="card_image">
            </div>
            <div class="m-3 p-2">
                <label for="card_level_rank">Level/Rank</label>
                <select name="card_level_rank" id="card_level_rank">
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
                <select name="card_attribute" id="card_attribute">
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
                <select name="card_card" id="card_card">
                    <option value="monster" selected>Monster</option>
                    <option value="pendulum">Pendulum</option>
                    <option value="spell">Spell</option>
                    <option value="trap">Trap</option>   
                </select>

                <label for="card_sub_card">Card Sub-Type</label>
                <select name="card_sub_card" id="card_sub_card">
                    <option value="normal" selected>Normal</option>
                    <option value="continuous">Continuous</option>
                    <option value="equip">Equip</option>
                    <option value="field">Field</option>
                    <option value="quick_play">Quick-Play</option>
                    <option value="ritual">Ritual</option>
                </select>

                <select name="card_sub_card" id="card_sub_card">
                    <option value="normal" selected>Normal</option>
                    <option value="continuous">Continuous</option>
                    <option value="counter">Counter</option>
                </select>

                <select name="card_sub_card" id="card_sub_card">
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
                <input type="radio" name="card_pendulum_link" id="card_is_none" value="card_is_none" checked>
                <label for="card_is_pendulum">Pendulum</label>
                <input type="radio" name="card_pendulum_link" id="card_is_pendulum" value="card_is_pendulum">
                <label for="card_is_link">Link</label>
                <input type="radio" name="card_pendulum_link" id="card_is_link" value="card_is_link">
            </div>
            <div class="m-3 p-2">
                <label for="card_link_rating">Link Rating</label>
                <input type="number" name="card_link_rating" id="card_link_rating" value="<?php if(isset($card_link_rating)){echo $card_link_rating ;} ?>"/>

                <label for="card_pscale_left">Left Scale</label>
                <input type="number" name="card_pscale_left" id="card_pscale_left" value="<?php if(isset($card_pscale_left)){echo $card_pscale_left ;} ?>"/>

                <label for="card_pscale_right">Right Scale</label>
                <input type="number" name="card_pscale_right" id="card_pscale_right" value="<?php if(isset($card_pscale_right)){echo $card_pscale_right ;} ?>"/>
            </div>
            <div class="m-3 p-2">
                <div class="m-3">
                    <input type="submit" name="submit" value="GENERATE SERVER JSON" class="btn btn-warning">
                </div>
                <div class="m-3">
                    <input type="submit" name="local_json" value="DOWNLOAD LOCAL JSON" class="btn btn-success">
                </div>
                <div class="m-3">
                    <input type="submit" name="new_card" value="CREATE BRAND NEW CARD" class="btn btn-danger">
                </div>
            </div>

            

        </form>
    </div>
</section>

<?php include('footer.php'); ?>
    
</body>
</html>
<!DOCTYPE html>
<html>
<head>
<style>
  #captcha {
    font-size: 20px;
    font-family: Arial, sans-serif;
  }
  .input-container {
    display: inline-block;
    margin-right: 10px;
    text-align: center;
  }
  .letter {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 5px;
    -webkit-user-select: none; /* Safari */
    -moz-user-select: none; /* Firefox */
    -ms-user-select: none; /* IE 10+ */
    user-select: none; /* Standard syntax */
  }
  .captcha-input {
    font-size: 16px;
    width: 30px;
    text-align: center;
    border: 1px solid #ccc;
    padding: 5px;
  }
  #timer {
    font-size: 16px;
    margin-top: 10px;
  }
</style>
</head>
<body>
<div id="captcha">Please complete the CAPTCHA:</div>
<div id="captchaWord">
  <div class="input-container">
    <div class="letter"></div>
    <input class="captcha-input" type="text" maxlength="1" autocomplete="off">
  </div>
  <div class="input-container">
    <div class="letter"></div>
    <input class="captcha-input" type="text" maxlength="1" autocomplete="off">
  </div>
  <div class="input-container">
    <div class="letter"></div>
    <input class="captcha-input" type="text" maxlength="1" autocomplete="off">
  </div>
  <div class="input-container">
    <div class="letter"></div>
    <input class="captcha-input" type="text" maxlength="1" autocomplete="off">
  </div>
  <div class="input-container">
    <div class="letter"></div>
    <input class="captcha-input" type="text" maxlength="1" autocomplete="off">
  </div>
</div>
<button id="verifyButton" name="verifyButton" type="submit">Verify</button>
<div id="timer">Time left: <span id="timeLeft">10</span> seconds</div>

<?php
  $timer = 10;
  $incorrectAttempts = 0;

  if (isset($_POST['verifyButton'])) {
    $userWord = strtoupper(implode('', $_POST['captchaInput']));
    $captchaWord = $_SESSION['captchaWord'];

    if ($userWord === $captchaWord) {
      echo "<script>alert('Captcha verification successful! Redirecting...'); window.location.href = 'https://www.example.com';</script>";
      exit();
    } else {
      $incorrectAttempts++;
      if ($incorrectAttempts >= 3) {
        echo "<script>alert('3 incorrect attempts. Please wait for 5 minutes.');";
        echo "document.getElementById('verifyButton').disabled = true;</script>";
        exit();
      }
    }
  }
?>

<?php
  $captchaWord = generateRandomWord();
  $_SESSION['captchaWord'] = $captchaWord;

  // Display random word above input fields
  foreach ($captchaWord as $letter) {
    echo '<div class="letter">' . $letter . '</div>';
    echo '<input class="captcha-input" type="text" name="captchaInput[]" maxlength="1" autocomplete="off">';
  }
?>

<div id="timer">Time left: <span id="timeLeft"><?php echo $timer; ?></span> seconds</div>
</form>

<?php
  function generateRandomWord() {
    $randomWord = '';
    for ($i = 0; $i < 5; $i++) {
      $randomWord .= chr(65 + rand(0, 25)); // Generates random uppercase letter
    }
    return str_split($randomWord);
  }
?>
</body>
</html>

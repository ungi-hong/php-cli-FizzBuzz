<?php

$app = new Game();

$app->execute();


class Game {

  //アプリの実行のメソッド
  public function execute(){
    echo <<<EOM
    -----------------------------------------------------------------------
    ゲームFizzBuz
    -----------------------------------------------------------------------
    勉強用のCLI (Command Line Interface)アプリ
    3の倍数の時は「Fizz」, 5の倍数の時は「Buzz」, 15の倍数の時は「FizzBuzz」と入力しましょう。
    対戦する人数を入力してください。
    -----------------------------------------------------------------------
    \n
    EOM;

    $number = $this->listenNumber('対戦相手の人数（1〜4人）を入力してください');

    if(!$number){
      echo '1~4の数字を入力してください。';
      return;
    }

    $gameCount = $this->listenCount('ゲームを何周するか1以上の数字で入力してください。例: 6など');

    if(!$gameCount) {
      echo '1以上の数字を入力してください。';
      return;
    }

    $count = 0;
    while($count < $gameCount){
      $opponent = $this->opponent($number,$count);
      $answer = $this->answer();
      $fizzBuzz = $this->fizzBuzz($opponent);

      if($answer === $fizzBuzz) {
        $count++;
        echo "正解";
        echo "\n";
      }else{
        echo"負け";
        break;
      }
    }

    echo "終了〜";

  }

  public function listenNumber(string $message){
    $input = $this->ask($message);

    //全角を半角に直す。
    $value = mb_convert_kana($input, 'n');

    if(!is_numeric($value)){
      return false;
    }

    // 強制的に整数にします。　
    $number = (int)$value;

    if(5 <= $number) {
      return false;
    }

    return $number;
  }


  public function listenCount(string $message){
    $input = $this->ask($message);

    //全角を半角に直す。
    $value = mb_convert_kana($input, 'n');

    if(!is_numeric($value)){
      return false;
    }

    // 強制的に整数にします。　
    $number = (int)$value;

    return $number;
  }


  public function ask(string $message) {
    // 標準入力
    echo escapeshellcmd($message);
    //stdinはstandard inputの略。
    return trim(fgets(STDIN));
  }

  public function answer() {
    $input = $this->ask('あなたの番です。');
    return $input;
  }

  public function fizzBuzz(int $i){
    if($i % 15 === 0) {
      return 'FizzBuzz';
    }
    elseif($i % 3 === 0) {
      return 'Fizz';
    }
    elseif($i % 5 === 0) {
      return 'Buzz';
    }
    else{
      return strval($i);
    }
  }

  public function opponent( int $number, int $count) {
    for($i = 1; $i <= ($number+1)*($count+1)-1; $i++) {
      if($i < ($number+1)*($count+1)-$number) {
        continue;
      }

      $fizzBuzz = $this->fizzBuzz($i);
      echo $fizzBuzz;
      echo "\n";
      sleep(1);
    }
    return $i;
  }
}
?>
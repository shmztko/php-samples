<?php
	/**
	 * メインの処理を実施します。
	 */
	function main() {
		session_start();
		
		$redirect_path = 'Location:hitblow.php';

		if (!isset($_SESSION['hitblow'])) {
			$hitblow = new HitAndBlow();
			$_SESSION['hitblow'] = $hitblow;
		} else {
			$hitblow = $_SESSION['hitblow'];
		}

		if (isset($_POST['user_input'])) {
			$user_input = htmlspecialchars($_POST['user_input']);

			if ($hitblow->validate_input($user_input)) {
				$result = $hitblow->check_answer(str_split($user_input));

				if ($result['correct'] == true) {
					// 正解したのでセッションを破棄
					if (isset($_COOKIE[session_name()])) {
						setcookie(session_name(), '', time()-42000, '/');
					}
					session_destroy();

					$message = 'You got a right answer -> ' . $user_input;
					header($redirect_path . '?message=' . $message);

				} else {
					$message = 'Your answer is wrong. try it again. <br/> hit -> ' . $result['hit'] . '<br/> blow -> ' . $result['blow'] ;
					header($redirect_path . '?message=' . $message);
				}
				exit;
			} else {
				$message = 'Invalid user input. -> '. $user_input;
				header($redirect_path . '?message=' . $message);
				exit;
			}

		} else {
			$message = 'No parameter was given to program.';
			header($redirect_path . '?message=' . $message);
			exit;
		}		
	}

	class HitAndBlow {

		/** 生成される正解の桁数 */
		const DIGIT_OF_ANSWER = 4;

		/** 生成された正解　*/
		private $answer; 

		/**
		 * このクラスが生成される時に呼び出されます。
		 * １つのインスタンスに対して、１つの正解を生成します。
		 */
		public function __construct() {
			$this->answer = $this->generate_answer();
		}

		/**
		 * 正解を取得します。
		 * @return array 答え
		 */
		public function get_answer() {
			return $this->answer;
		}

		/**
		 * ユーザ入力が正しいフォーマットのものかチェックします。
		 * @param string $user_input ユーザ入力
		 * @return bool 正しいフォーマットなら True, それ以外の場合 False
		 */
		public function validate_input($user_input) {
			// 入力フォーマットのチェック
			if (!preg_match("/^[0-9]{" . HitAndBlow::DIGIT_OF_ANSWER . "}$/", $user_input)) {
				return false;
			}

			// 同じ数字が重複して出現していないことをチェック
			for ($i = 0; $i < mb_strlen($user_input); $i++) {
				if (substr_count($user_input, $user_input[$i]) > 1 ) {
					return false;
				}
			}

			return true;
		}

		/**
		 * 入力された答えが正しいかチェックします。
		 * @param array $given_answer 入力された答え
		 * @return array チェック結果の情報（Hit数、Blow数、正解かどうか）
		 */
		public function check_answer($given_answer) {
			$hit_count = 0;
			$blow_count = 0;
			for ($i = 0; $i < HitAndBlow::DIGIT_OF_ANSWER; $i++) {
				if ($given_answer[$i] == $this->answer[$i]) {
					print 'hit';
					$hit_count++;
				} else if (in_array($given_answer[$i], $this->answer)) {
					print 'blow';
					$blow_count++;
				} else {
					print 'none';
					// N/A
				}
			}
			return array('hit' => $hit_count, 'blow' => $blow_count, 'correct' => $hit_count == HitAndBlow::DIGIT_OF_ANSWER);
		}

		/**
		 *　Hit-And-Blowの答えを生成します。
		 * @return array 答え
		　*/
		private function generate_answer() {
			$result = [];
			for ($i = 0; $i < HitAndBlow::DIGIT_OF_ANSWER; $i++) {
				$digit = mt_rand(0, 9);
				while (in_array($digit, $result)) {
					$digit = mt_rand(0, 9);
				}
				$result[$i] = $digit;
			}
			return $result;
		}
	}

	main();
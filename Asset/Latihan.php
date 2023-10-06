<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["score"])) {
  $score = $_POST["score"]; // Ambil data skor dari permintaan POST

  // Lakukan validasi atau manipulasi data skor jika diperlukan

  // Simpan data skor ke dalam database
  // Ganti koneksi dan operasi SQL sesuai dengan database Anda
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "learning";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO hasil_ujian (skor) VALUES ('$score')";

  if ($conn->query($sql) === TRUE) {
    echo "Skor berhasil disimpan dalam database.";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Latihan</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body style=" background-color: #f2f2f2; ">

  <!-------------------  FIRST UPPER NAVIGATION ------------------------------>


  <!---------------------------------------------------------------------------->


  <!-------------------------  MAIN NAVIGATION ------------------------>

  <header id="nav">
    <section class="navsec">
      <!-- LOGO SECTION -->

      <div class="logo" style="color: #f2f2f2;">
        <h1> Nihongo Education </h1>
      </div>

      <!-- TOPIC SECTIONS  -->
      <nav>
        <a href="../index.php"> Beranda
          <div class="dropdown">
            <button class="dropbtn"><a href="#">Pelajaran</a></button>
            <div class="dropdown-content"><a href="Hiragana.php">Hiragana</a>
              <a href="Katakana.php">Katakana</a>
              <a href="Kosakata.php">Kosakata</a>
            </div>
          </div>
        </a>
        <a href="#"> Latihan</a>
      </nav>
    </section>
    </div>
    <hr style="border: 1px solid black; margin: 0;">
  </header></br></br></br>
  <!---------------------------------------------------------------------------->

  <!-- jquery for maximum compatibility -->
  <script>
    var quiztitle = "Latihan Soal";

    /**
     * Set the information about your questions here. The correct answer string needs to match
     * the correct choice exactly, as it does string matching. (case sensitive)
     *
     */

    var quiz = [{
        "question": "huruf hiragana dibawah ini mewakili dalam bahasa Jepang",
        "image": "../images/hiragana/a.png",
        "choices": [
          "Ka",
          "a",
          "sa",
          "na"
        ],
        "Benar": "a",
        "explanation": "Gambar tadi merupakan huruf hiragana a (あ)",
      },
      {
        "question": "Bagaimana cara mengatakan (terima kasih) dalam bahasa Jepang?",
        "choices": [
          "ごめんなさい (Gomen nasai)",
          "さようなら (Sayounara)",
          "はい (Hai)",
          "ありがとう (Arigatou)"
        ],
        "Benar": "ありがとう (Arigatou)",
        "explanation": "ありがとう (Arigatou) merupakan terimaksih dalam bahasa jepang",
      },
      {
        "question": "Kapan Anda biasanya menggunakan karakter Katakana dalam bahasa Jepang?",
        "choices": [
          "Untuk kata-kata bahasa Jepang asli",
          "Untuk menulis kata-kata penting",
          "Untuk kata-kata asing atau nama asing",
          "Untuk penulisan formal"
        ],
        "Benar": "Untuk kata-kata asing atau nama asing",
        "explanation": "Penggunaan huruf katakana digunakan Untuk kata asing/nama asing ",
      },
      {
        "question": "Apa arti kata (Hon) dalam bahasa jepang",
        "image": "https://bishun.18dao.net/bishun_pic/%E5%8E%BB.gif",
        "choices": [
          "Buku",
          "Pohon",
          "air",
          "Makanan"
        ],
        "Benar": "Buku",
        "explanation": "Kata (hon) ialah arti dari buku",
      },
      {
        "question": "Apa yang merupakan salam yang digunakan pada malam hari dalam bahasa Jepang?",
        "image": "",
        "choices": [
          "こんにちは (Konnichiwa)",
          " おはよう (Ohayou)",
          "さようなら (Sayounara)",
          " こんばんは (Konbanwa)"
        ],
        "Benar": " こんばんは (Konbanwa)",
        "explanation": " こんばんは (Konbanwa) merupakan kata salam saat malam hari dalam bahasa jepang",
      },
    ];

    /******* No need to edit below this line *********/
    var currentquestion = 0,
      score = 0,
      submt = true,
      picked;
    jQuery(document).ready(function(e) {
      function h(i) {
        return e(document.createElement("div")).text(i).html()
      }

      function b(k) {
        if (typeof k !== "undefined" && e.type(k) == "array") {
          e("#choice-block").empty();
          for (var j = 0; j < k.length; j++) {
            e(document.createElement("li")).addClass("choice choice-box").attr("data-index", j).text(k[j]).appendTo("#choice-block")
          }
        }
      }

      function d() {
        submt = true;
        e("#explanation").empty();
        e("#question").text(quiz[currentquestion]["question"]);
        e("#pager").text("Question " + Number(currentquestion + 1) + " of " + quiz.length);
        if (quiz[currentquestion].hasOwnProperty("image") && quiz[currentquestion]["image"] != "") {
          if (e("#question-image").length == 0) {
            e(document.createElement("img")).addClass("question-image").attr("id", "question-image").attr("src", quiz[currentquestion]["image"]).attr("alt", h(quiz[currentquestion]["question"])).insertAfter("#question")
          } else {
            e("#question-image").attr("src", quiz[currentquestion]["image"]).attr("alt", h(quiz[currentquestion]["question"]))
          }
        } else {
          e("#question-image").remove()
        }
        b(quiz[currentquestion]["choices"]);
        c()
      }

      function f(i) {
        if (quiz[currentquestion]["choices"][i] == quiz[currentquestion]["Benar"]) {
          e(".choice").eq(i).css({
            "background-color": "#50D943"
          });
          e("#explanation").html("<strong>Benar!</strong> " + h(quiz[currentquestion]["explanation"]));
          score++
        } else {
          e(".choice").eq(i).css({
            "background-color": "#D92623"
          });
          e("#explanation").html("<strong>Salah.</strong> " + h(quiz[currentquestion]["explanation"]))
        }
        currentquestion++;
        e("#submitbutton").html("SOAL BERIKUTNYA &raquo;").on("click", function() {
          if (currentquestion == quiz.length) {
            a()
          } else {
            e(this).text("JAWABAN").css({
              color: "#222"
            }).off("click");
            d()
          }
        })
      }

      function c() {
        e(".choice").on("mouseover", function() {
          e(this).css({
            "background-color": "#e1e1e1"
          })
        });
        e(".choice").on("mouseout", function() {
          e(this).css({
            "background-color": "#fff"
          })
        });
        e(".choice").on("click", function() {
          picked = e(this).attr("data-index");
          e(".choice").removeAttr("style").off("mouseout mouseover");
          e(this).css({
            "border-color": "#222",
            "font-weight": 700,
            "background-color": "#c1c1c1"
          });
          if (submt) {
            submt = false;
            e("#submitbutton").css({
              color: "#000"
            }).on("click", function() {
              e(".choice").off("click");
              e(this).off("click");
              f(picked)
            })
          }
        })
      }

      function a() {
        e("#explanation").empty();
        e("#question").empty();
        e("#choice-block").empty();
        e("#submitbutton").remove();
        e("#question").append("<p>Nilai yang kamu dapatkan adalah</p>");
        e(document.createElement("h2")).css({
          "text-align": "center",
          "font-size": "4em"
        }).text(Math.round(score / quiz.length * 100)).insertAfter("#question");

        var calculatedScore = Math.round(score / quiz.length * 100);

        // Kirim data skor ke server menggunakan AJAX
        jQuery.ajax({
          type: "POST",
          url: "#.php", // Ganti dengan URL skrip PHP yang Anda buat
          data: {
            score: calculatedScore
          },
          success: function(response) {
            console.log(response); // Tampilkan respons dari server (opsional)
          },
          error: function(xhr, status, error) {
            console.error(error); // Tampilkan pesan error jika terjadi kesalahan
          }
        });
      }

      function g() {
        if (typeof quiztitle !== "undefined" && e.type(quiztitle) === "string") {
          e(document.createElement("h1")).text(quiztitle).appendTo("#frame")
        } else {
          e(document.createElement("h1")).text("Quiz").appendTo("#frame")
        }
        if (typeof quiz !== "undefined" && e.type(quiz) === "array") {
          e(document.createElement("p")).addClass("pager").attr("id", "pager").text("Question 1 of " + quiz.length).appendTo("#frame");
          e(document.createElement("h2")).addClass("question").attr("id", "question").text(quiz[0]["question"]).appendTo("#frame");
          if (quiz[0].hasOwnProperty("image") && quiz[0]["image"] != "") {
            e(document.createElement("img")).addClass("question-image").attr("id", "question-image").attr("src", quiz[0]["image"]).attr("alt", h(quiz[0]["question"])).appendTo("#frame")
          }
          e(document.createElement("p")).addClass("explanation").attr("id", "explanation").html("&nbsp;").appendTo("#frame");
          e(document.createElement("ul")).attr("id", "choice-block").appendTo("#frame");
          b(quiz[0]["choices"]);
          e(document.createElement("div")).addClass("choice-box").attr("id", "submitbutton").text("JAWABAN").css({
            "font-weight": 700,
            color: "#222",
            padding: "30px 0"
          }).appendTo("#frame");
          c()
        }
      }
      g()
    });
  </script>
  <style type="text/css">
    /*css reset */
    html,
    body,
    div,
    span,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    code,
    small,
    strike,
    strong,
    sub,
    sup,
    b,
    u,
    i {
      border: 0;
      font-size: 100%;
      font: inherit;
      vertical-align: baseline;
      margin: 0;
      padding: 0;
    }

    body {
      line-height: 1;
      font: normal 0.9em/1em "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    ol,
    ul {
      list-style: none;
    }

    strong {
      font-weight: 700;
    }

    #frame {
      max-width: 80%;
      width: auto;
      border: 2px solid #000;
      background: #f2f2f2;
      padding: 10px;
      margin: 3px;
    }

    h1 {
      font: normal bold 2em/1.8em "Helvetica Neue", Helvetica, Arial, sans-serif;
      text-align: center;
      padding: 0;
      width: auto
    }

    h2 {
      font: italic bold 1.3em/1.2em "Helvetica Neue", Helvetica, Arial, sans-serif;
      padding: 0;
      text-align: center;
      margin: 20px 0;
    }

    p.pager {
      margin: 5px 0 5px;
      font: bold 1em/1em "Helvetica Neue", Helvetica, Arial, sans-serif;
      color: #999;
    }

    img.question-image {
      display: block;
      max-width: 220px;
      margin: 10px auto;
      border: 1px solid #ccc;
      width: 80%;
      height: auto;
    }

    #choice-block {
      display: block;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    #submitbutton {
      background: #fdfcdc;
    }

    #submitbutton:hover {
      background: #fcca32;
    }

    #explanation {
      margin: 0 auto;
      padding: 20px;
      width: 75%;
    }

    .choice-box {
      display: block;
      text-align: center;
      margin: 8px auto;
      padding: 10px 0;
      border: 1px solid #666;
      cursor: pointer;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
    }
  </style>
  <center>
    <div id="frame" role="content"></div>
  </center></br></br></br>

  </br>
  </br>

  <!--------------------------------  footer -------------------------->


  <!---------------COPY RIGHT ----------->
  <div style=" background-color: #b72117 ;  text-align:center;  ">
    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 1440 320">
      <path fill="#f2f2f2" fill-opacity="1" d="M0,32L40,69.3C80,107,160,181,240,208C320,235,400,213,480,181.3C560,149,640,107,720,85.3C800,64,880,64,960,85.3C1040,107,1120,149,1200,160C1280,171,1360,149,1400,138.7L1440,128L1440,0L1400,0C1360,0,1280,0,1200,0C1120,0,1040,0,960,0C880,0,800,0,720,0C640,0,560,0,480,0C400,0,320,0,240,0C160,0,80,0,40,0L0,0Z">
      </path>
    </svg>
  </div>

  <hr style="border: 2px solid black; margin: 0;">

  <div class="cpyrgt">
    <div>
      <a href="https://www.youtube.com/c/ugtvofficial" style=" color: rgb(255, 255, 255);"><svg xmlns="https://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
          <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z" />
        </svg></a> &nbsp; &nbsp; &nbsp;
      <a href="https://id-id.facebook.com/gunadarma" style=" color: rgb(255, 255, 255);"><svg xmlns="https://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
          <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
        </svg></a> &nbsp; &nbsp; &nbsp;
      <a href="https://www.instagram.com/anakgundardotco" style=" color: rgb(255, 255, 255);"><svg xmlns="https://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
          <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
        </svg></a> &nbsp; &nbsp; &nbsp;
      <a href="https://studentsite.gunadarma.ac.id/index.php/site/index" style=" color: rgb(255, 255, 255);"><svg xmlns="https://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
          <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
        </svg></a>
    </div>

    <div>
      <p>Copyright &#169;
        <a href="#" style="color:rgb(255, 255, 255);">Nihongo Education </a>2023. Created By Dikri
      </p>
    </div>
  </div>

  <!---------------------------------------------------------------------------->
</body>

</html>
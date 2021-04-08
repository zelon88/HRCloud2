<?php
/*//
HRCLOUD2-PLUGIN-START
App Name: Smart-Lightbulb
App Version: 1.0 (4-7-2021 20:00)
App License: GPLv3
App Author: urish, Sagi363, TalAter & zelon88
App Description: A simple HRCloud2 App for controlling Bluetooth lightbulbs.
App Integration: 0 (False)
App Permission: 1 (Everyone)
HRCLOUD2-PLUGIN-END
//*/
$noStyles = 1;
?>

<!doctype html>
<html>

<head>
	<title>Magic Blue</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Origin Trial Token, feature = Web Bluetooth, origin = https://urish.github.io, expires = 2017-01-24 -->
	<meta http-equiv="origin-trial" data-feature="Web Bluetooth" data-expires="2017-01-24" content="AkHwGzaZWjkkErTNEgXn3R3rT8pTJzgFXwVYVP1gkWIbxTchTkCjbj3pKaMbDXe8oDvq3pgvZ6N2UcSfgX0TvwsAAABaeyJvcmlnaW4iOiAiaHR0cHM6Ly91cmlzaC5naXRodWIuaW86NDQzIiwgImZlYXR1cmUiOiAiV2ViQmx1ZXRvb3RoIiwgImV4cGlyeSI6IDE0ODUyNzA5Njh9">

	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="Styles/material-indigo-pink.css">
	<link rel="stylesheet" href="styles.css" />
	<link rel="manifest" href="manifest.json" />

	<script defer src="material.min.js"></script>
    <script src="iro.min.js"></script>

</head>

<body>

	<div class="app-layout mdl-layout mdl-js-layout">

		<main class="mdl-layout__content">

			<div class="title-and-connect">
				<h3 id="title">Web Light Bulb</h3>
				<div class="connect-another hidden">
					<button onclick="connect()" class="mdl-button mdl-js-button mdl-button--fab mdl-button--raised mdl-button--colored mdl-js-ripple-effect"
					    style="background: rgb(63,81,181); top: 15px;">
                        <i class="material-icons connect-another-icon">bluetooth</i> +
                    </button>
				</div>
			</div>

			<button onclick="connect()" class="connect-button mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                <i class="material-icons">bluetooth</i> Connect
            </button>

			<div class="power-button hidden">
				<button onclick="turnOnOff()" class="mdl-button mdl-js-button mdl-button--fab mdl-button--raised mdl-js-ripple-effect on-off">
                    <i class="material-icons">lightbulb_outline</i>
                </button>
			</div>

            <div class="wheel hidden" id="color-wheel"></div>

			<div class="color-buttons hidden">
				<button onclick="red()" class="mdl-button mdl-js-button mdl-button--fab mdl-button--raised mdl-js-ripple-effect" style="background:#ffa0a0">
                    R
                </button>

				<button onclick="green()" class="mdl-button mdl-js-button mdl-button--fab mdl-button--raised mdl-js-ripple-effect" style="background:#a0ffa0">
                    G
                </button>

				<button onclick="blue()" class="mdl-button mdl-js-button mdl-button--fab mdl-button--raised mdl-js-ripple-effect" style="background:#a0a0ff">
                    B
                </button>

			</div>

			<div class="mic-button hidden">
				<button onclick="listen()" class="mdl-button mdl-js-button mdl-button--fab mdl-button--raised mdl-js-ripple-effect">
                    <i class="material-icons">microphone</i>
                </button>
			</div>
		</main>
	</div>

	<script src="annyang.js"></script>
	<script src="bulb.js"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Background Music</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        .music-controls {
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h1>Background Music Test</h1>

    <!-- Background Music -->
    <audio id="bg-music" loop>
        <source src="A-X-L.m4a" type="audio/mp4"> <!-- Ensure the file is in the correct folder -->
        Your browser does not support the audio element.
    </audio>

    <!-- Music Controls -->
    <div class="music-controls">
        <button onclick="toggleMusic()">Play/Pause</button>
        <input type="range" id="volume-control" min="0" max="1" step="0.1" value="1" onchange="setVolume(this.value)">
    </div>

    <script>
        let music = document.getElementById("bg-music");

        function toggleMusic() {
            if (music.paused) {
                music.play();
            } else {
                music.pause();
            }
        }

        function setVolume(value) {
            music.volume = value;
        }
    </script>
</body>
</html>

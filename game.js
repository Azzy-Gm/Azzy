var Snake = (function() {

  const INITIAL_TAIL = 4;
  var fixedTail = true;
  var intervalID;

  var tileCount = 30;
  var gridSize = 400 / tileCount;

  const INITIAL_PLAYER = { x: Math.floor(tileCount / 2), y: Math.floor(tileCount / 2) };

  var velocity = { x: 0, y: 0 };
  var player = { x: INITIAL_PLAYER.x, y: INITIAL_PLAYER.y };

  var fruit = { x: 1, y: 1 };

  var trail = [];
  var tail = INITIAL_TAIL;

  var reward = 0;
  var points = 0;
  var pointsMax = 0;

  function setup() {
    canv = document.getElementById('gc');
    ctx = canv.getContext('2d');
    game.reset();
  }

  var game = {

    reset: function() {
      ctx.fillStyle = 'grey';
      ctx.fillRect(0, 0, canv.width, canv.height);

      tail = INITIAL_TAIL;
      points = 0;
      velocity.x = 0;
      velocity.y = 0;
      player.x = INITIAL_PLAYER.x;
      player.y = INITIAL_PLAYER.y;

      reward = -1;

      trail = [];
      trail.push({ x: player.x, y: player.y });

      game.RandomFruit();
    },

    RandomFruit: function() {
      fruit.x = Math.floor(Math.random() * tileCount);
      fruit.y = Math.floor(Math.random() * tileCount);

      // Cek apakah buah muncul di badan ular
      while (trail.some(segment => segment.x === fruit.x && segment.y === fruit.y)) {
        fruit.x = Math.floor(Math.random() * tileCount);
        fruit.y = Math.floor(Math.random() * tileCount);
      }
    },

    loop: function() {
      reward = -0.1;

      autoMove(); // Memanggil fungsi otomatis

      player.x += velocity.x;
      player.y += velocity.y;

      ctx.fillStyle = 'rgba(40,40,40,0.8)';
      ctx.fillRect(0, 0, canv.width, canv.height);

      trail.push({ x: player.x, y: player.y });
      while (trail.length > tail) trail.shift();

      // cek tabrakan dinding
      if (player.x < 0 || player.x >= tileCount || player.y < 0 || player.y >= tileCount) {
        game.reset();
        return;
      }

      // Cek tabrakan dengan diri sendiri
      if (trail.slice(0, -1).some(segment => segment.x === player.x && segment.y === player.y)) {
        game.reset();
        return;
      }

      ctx.fillStyle = 'green';
      trail.forEach((segment, index) => {
        ctx.fillRect(segment.x * gridSize + 1, segment.y * gridSize + 1, gridSize - 2, gridSize - 2);
        ctx.fillStyle = 'lime';
      });

      // Cek jika ular makan apel
      if (player.x === fruit.x && player.y === fruit.y) {
    tail++; // Tambah panjang ekor setiap kali makan apel
    points++;
    if (points > pointsMax) pointsMax = points;
    reward = 1;
    game.RandomFruit();
}

      ctx.fillStyle = 'red';
      ctx.fillRect(fruit.x * gridSize + 1, fruit.y * gridSize + 1, gridSize - 2, gridSize - 2);

      ctx.fillStyle = 'white';
      ctx.font = "bold small-caps 16px Helvetica";
      ctx.fillText("points: " + points, 288, 40);
      ctx.fillText("top: " + pointsMax, 292, 60);
    }
  }

  function autoMove() {
    let dx = fruit.x - player.x;
    let dy = fruit.y - player.y;

    let possibleMoves = [];

    // Tambahkan semua kemungkinan gerakan
    if (dx > 0) possibleMoves.push({ x: 1, y: 0 }); // Kanan
    if (dx < 0) possibleMoves.push({ x: -1, y: 0 }); // Kiri
    if (dy > 0) possibleMoves.push({ x: 0, y: 1 }); // Bawah
    if (dy < 0) possibleMoves.push({ x: 0, y: -1 }); // Atas

    // Cek apakah gerakan aman (tidak menabrak dinding atau tubuh sendiri)
    let safeMoves = possibleMoves.filter(move => {
      let newX = player.x + move.x;
      let newY = player.y + move.y;

      // Cek apakah keluar dari batas area
      if (newX < 0 || newX >= tileCount || newY < 0 || newY >= tileCount) return false;

      // Cek apakah menabrak tubuh sendiri
      if (trail.some(segment => segment.x === newX && segment.y === newY)) return false;

      return true;
    });

    // Pilih arah terbaik yang aman
    if (safeMoves.length > 0) {
      velocity = safeMoves[0];
    } else {
      // Jika tidak ada jalan aman, tetap diam atau reset (opsional)
      velocity = { x: 0, y: 0 };
    }
  }

  return {
    start: function(fps = 120) {
      window.onload = setup;
      intervalID = setInterval(game.loop, 100 / fps);
    },
    reset: game.reset
  };

})();
document.getElementById("playButton").addEventListener("click", function() {
    Snake.start(8);
    document.getElementById("playButton").style.display = "none"; // Sembunyikan tombol setelah mulai
});

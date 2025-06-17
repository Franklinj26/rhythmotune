// Variables globales
let currentSongIndex = 0;
let songs = [];
const audio = document.getElementById('audioPlayer');
let isPlaying = false;

// Función mejorada para cargar canciones
function loadSong(song) {
    // Actualizar la interfaz
    document.getElementById('currentSongTitle').textContent = song.title;
    document.getElementById('currentSongArtist').textContent = song.artist;
    document.getElementById('currentSongCover').src = song.cover;
    document.getElementById('duration').textContent = song.duration || formatTime(audio.duration);
    
    // Configurar el elemento de audio
    audio.src = song.audio;
    
    // Registrar la reproducción en la base de datos
    if (song.id) {
        registerPlay(song.id);
    }
    
    // Cargar y reproducir si estaba en play
    audio.load();
    if (isPlaying) {
        audio.play().catch(error => {
            console.error("Error al reproducir:", error);
            showError("No se pudo reproducir la canción");
        });
    }
}

// Función para registrar reproducción en la BD
function registerPlay(songId) {
    fetch('register_play.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `song_id=${songId}`
    })
    .then(response => response.json())
    .catch(error => console.error("Error al registrar reproducción:", error));
}

// Función para reproducir/pausar
function togglePlay() {
    if (isPlaying) {
        audio.pause();
        document.getElementById('playBtn').textContent = '▶';
    } else {
        audio.play().then(() => {
            document.getElementById('playBtn').textContent = '⏸';
        }).catch(error => {
            console.error("Error al reproducir:", error);
        });
    }
    isPlaying = !isPlaying;
}

// Funciones para control de canciones
function nextSong() {
    if (songs.length === 0) return;
    currentSongIndex = (currentSongIndex + 1) % songs.length;
    loadSong(songs[currentSongIndex]);
    if (isPlaying) audio.play();
}

function previousSong() {
    if (songs.length === 0) return;
    currentSongIndex = (currentSongIndex - 1 + songs.length) % songs.length;
    loadSong(songs[currentSongIndex]);
    if (isPlaying) audio.play();
}

// Función para iniciar reproducción desde una tarjeta
function playSongFromCard(songData) {
    // Buscar si la canción ya está en la lista
    const songIndex = songs.findIndex(s => s.audio === songData.audio);
    
    if (songIndex !== -1) {
        currentSongIndex = songIndex;
    } else {
        songs = [songData]; // Reemplaza con tu lista completa si es necesario
        currentSongIndex = 0;
    }
    
    loadSong(songs[currentSongIndex]);
    if (!isPlaying) {
        togglePlay();
    }
}

// Control de progreso
audio.addEventListener('timeupdate', function() {
    const progress = (audio.currentTime / audio.duration) * 100;
    document.getElementById('songProgress').value = progress;
    document.getElementById('currentTime').textContent = formatTime(audio.currentTime);
});

document.getElementById('songProgress').addEventListener('input', function() {
    if (audio.duration) {
        audio.currentTime = (this.value / 100) * audio.duration;
    }
});

// Control de volumen
document.getElementById('volumeSlider').addEventListener('input', function() {
    audio.volume = this.value;
});

// Cuando termina la canción
audio.addEventListener('ended', nextSong);

// Formatear tiempo (mm:ss)
function formatTime(seconds) {
    if (isNaN(seconds)) return "0:00";
    const mins = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
}

// Función para mostrar errores
function showError(message) {
    console.error(message);
    // Puedes implementar un sistema de notificaciones aquí
}
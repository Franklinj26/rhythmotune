// Variables globales
let currentSongIndex = 0;
let songs = [];
let isPlaylistMode = false; 
const audio = document.getElementById('audioPlayer');
let isPlaying = false;



// Función para guardar el estado
function saveState() {
    // Convertimos el array de canciones a string manualmente
    let songsString = '';
    for (let i = 0; i < songs.length; i++) {
        songsString += songs[i].title + '|' + 
                      songs[i].artist + '|' + 
                      songs[i].audio + '|' + 
                      songs[i].cover + '|' + 
                      songs[i].duration + '|' + 
                      songs[i].id + ';';
    }
    
    localStorage.setItem('currentSongIndex', currentSongIndex);
    localStorage.setItem('songs', songsString);
    localStorage.setItem('isPlaying', isPlaying);
    localStorage.setItem('currentTime', audio.currentTime);
    localStorage.setItem('volume', audio.volume);
    localStorage.setItem('isPlaylistMode', isPlaylistMode);
}

// Función para cargar el estado
function loadState() {
    const savedIndex = localStorage.getItem('currentSongIndex');
    const savedSongs = localStorage.getItem('songs');
    const savedIsPlaying = localStorage.getItem('isPlaying');
    const savedCurrentTime = localStorage.getItem('currentTime');
    const savedVolume = localStorage.getItem('volume');
    const savedIsPlaylistMode = localStorage.getItem('isPlaylistMode');
    
    if (savedSongs && savedSongs !== '') {
        // Parseamos las canciones manualmente
        songs = [];
        const songsArray = savedSongs.split(';');
        for (let i = 0; i < songsArray.length; i++) {
            if (songsArray[i] === '') continue;
            const songData = songsArray[i].split('|');
            songs.push({
                title: songData[0],
                artist: songData[1],
                audio: songData[2],
                cover: songData[3],
                duration: songData[4],
                id: parseInt(songData[5])
            });
        }
        
        if (savedIndex) currentSongIndex = parseInt(savedIndex);
        if (savedIsPlaying) isPlaying = savedIsPlaying === 'true';
        if (savedCurrentTime) audio.currentTime = parseFloat(savedCurrentTime);
        if (savedVolume) audio.volume = parseFloat(savedVolume);
        if (savedIsPlaylistMode) isPlaylistMode = savedIsPlaylistMode === 'true';
        
        // Cargar la canción actual
        if (songs.length > 0) {
            loadSong(songs[currentSongIndex], false);
            
            if (isPlaying) {
                setTimeout(() => {
                    audio.play().catch(e => console.log("No se pudo reproducir automáticamente:", e));
                }, 100);
            }
        }
    }
}

// Función para cargar todas las canciones disponibles
function loadAllSongs(songsList) {
    songs = songsList;
}

// Función para reproducir una canción específica
function playSong(index) {
    if (index >= 0 && index < songs.length) {
        currentSongIndex = index;
        loadSong(songs[currentSongIndex]);
        if (!isPlaying) {
            togglePlay();
        }
    }
}

// Función para cargar una canción
function loadSong(song, saveState = true) {
    if (!song) return;
    
    // Pausar y resetear el audio antes de cargar nueva canción
    audio.pause();
    audio.currentTime = 0;
    
    document.getElementById('currentSongTitle').textContent = song.title;
    document.getElementById('currentSongArtist').textContent = song.artist;
    document.getElementById('currentSongCover').src = song.cover;
    document.getElementById('duration').textContent = song.duration || formatTime(audio.duration);
    
    audio.src = song.audio;
    
    // Cargar la nueva fuente de audio
    audio.load();
    
    if (song.id) {
        registerPlay(song.id);
    }
    
    if (saveState) {
        saveState();
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
    }).catch(error => console.error("Error al registrar reproducción:", error));
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
    saveState();
}

// Funciones de control
function nextSong() {
    if (songs.length === 0) return;
    
    currentSongIndex = (currentSongIndex + 1) % songs.length;
    loadAndPlaySong();
}

function previousSong() {
    if (songs.length === 0) return;
    
    currentSongIndex = (currentSongIndex - 1 + songs.length) % songs.length;
    loadAndPlaySong();
}

// Función para establecer el modo playlist
function setPlaylistMode(enabled) {
    isPlaylistMode = enabled;
}

// Función para cargar canciones
function loadSongs(songsList, isPlaylist = false) {
    songs = songsList;
    isPlaylistMode = isPlaylist;
    currentSongIndex = 0;
    saveState();
}

// Función para reproducir desde tarjeta
function playSongFromCard(songData) {
    // Verificar si la canción está en la lista global (allSongs)
    const songIndex = allSongs.findIndex(s => s.audio === songData.audio);
    
    if (songIndex !== -1) {
        // Usar la lista global de canciones
        songs = [...allSongs];
        currentSongIndex = songIndex;
        isPlaylistMode = false;
    } else {
        // Si no está en allSongs, crear lista con solo esta canción
        songs = [songData];
        currentSongIndex = 0;
        isPlaylistMode = false;
    }
    
    loadAndPlaySong();
}

// Función para reproducir playlist
function playPlaylist() {
    if (playlistSongs.length > 0) {
        songs = [...playlistSongs]; // Copia de las canciones de la playlist
        currentSongIndex = 0;
        isPlaylistMode = true; // Activar modo playlist
        loadAndPlaySong();
    } else {
        alert('No hay canciones para reproducir en esta playlist');
    }
}

// Función para reproducir álbum
function playAlbum() {
    if (albumSongs.length > 0) {
        songs = [...albumSongs]; // Copia de las canciones del álbum
        currentSongIndex = 0;
        isPlaylistMode = true; // Activar modo playlist
        loadAndPlaySong();
    } else {
        alert('No hay canciones en este álbum');
    }
}

function loadAndPlaySong() {
    if (songs.length === 0) return;
    
    loadSong(songs[currentSongIndex], false);
    
    // Limpiar eventos anteriores para evitar duplicados
    audio.oncanplaythrough = null;
    audio.onerror = null;
    
    audio.oncanplaythrough = function() {
        audio.play().then(() => {
            isPlaying = true;
            document.getElementById('playBtn').textContent = '⏸';
            saveState();
        }).catch(error => {
            console.error("Error al reproducir:", error);
        });
    };
    
    audio.onerror = function() {
        console.error("Error al cargar el audio");
    };
}
// Función para reproducir una canción específica del álbum/playlist
function playSongFromList(index, songList, isAlbumOrPlaylist = true) {
    songs = [...songList];
    currentSongIndex = index;
    isPlaylistMode = isAlbumOrPlaylist;
    loadAndPlaySong();
}

// Control de progreso
audio.addEventListener('timeupdate', function() {
    document.getElementById('songProgress').value = (audio.currentTime / audio.duration) * 100 || 0;
    document.getElementById('currentTime').textContent = formatTime(audio.currentTime);
});

// Inicializar con todas las canciones cuando se cargue la página
document.addEventListener('DOMContentLoaded', function() {
    if (typeof allSongs !== 'undefined' && allSongs.length > 0) {
        loadAllSongs(allSongs);
    }
});

document.getElementById('songProgress').addEventListener('input', function() {
    if (audio.duration) {
        audio.currentTime = (this.value / 100) * audio.duration;
    }
});

// Control de volumen
document.getElementById('volumeSlider').addEventListener('input', function() {
    audio.volume = this.value;
    saveState();
});

// Cuando termina la canción
audio.addEventListener('ended', function() {
    if (isPlaylistMode) {
        // Solo pasar a la siguiente canción si estamos en modo playlist/álbum
        nextSong();
    } else {
        // Si no está en modo playlist, simplemente pausar
        isPlaying = false;
        document.getElementById('playBtn').textContent = '▶';
        saveState();
    }
});

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

// Inicialización
function initPlayer() {
    if (document.getElementById('musicPlayer')) {
        loadState();
        document.getElementById('volumeSlider').value = audio.volume;
    }
}

document.addEventListener('DOMContentLoaded', initPlayer);

// BUSCADOR PRINCIPAL (bien.php)
function performSearch() {
    const input = document.getElementById('searchInput');
    if (!input) return; // Solo ejecuta si existe el campo de búsqueda
    
    const filter = input.value.toUpperCase();
    
    // Buscar en canciones
    const songsGrid = document.getElementById('songsGrid');
    if (songsGrid) {
        const songs = songsGrid.getElementsByClassName('music-card');
        for (let song of songs) {
            const title = song.querySelector('.song-title')?.textContent.toUpperCase() || '';
            const artist = song.querySelector('.song-artist')?.textContent.toUpperCase() || '';
            song.style.display = (title.includes(filter) || artist.includes(filter)) ? "" : "none";
        }
    }
    
    // Buscar en artistas
    const artistsGrid = document.getElementById('artistsGrid');
    if (artistsGrid) {
        const artists = artistsGrid.getElementsByClassName('artist-card');
        for (let artist of artists) {
            const name = artist.querySelector('span')?.textContent.toUpperCase() || '';
            artist.style.display = name.includes(filter) ? "" : "none";
        }
    }
    
    // Buscar en álbumes
    const albumsGrid = document.getElementById('albumsGrid');
    if (albumsGrid) {
        const albums = albumsGrid.getElementsByClassName('album-card');
        for (let album of albums) {
            const title = album.querySelector('.album-title')?.textContent.toUpperCase() || '';
            const artist = album.querySelector('.album-artist')?.textContent.toUpperCase() || '';
            album.style.display = (title.includes(filter) || artist.includes(filter)) ? "" : "none";
        }
    }
}

// Función para actualizar el contador de canciones seleccionadas
function updateCounter() {
    const selectedCount = document.querySelectorAll('.song-add-item input[type="checkbox"]:checked').length;
    const counterElement = document.getElementById('selectedCounter');
    if (counterElement) {
        counterElement.textContent = `${selectedCount} seleccionada${selectedCount !== 1 ? 's' : ''}`;
    }
}
// Función para cargar una playlist completa
function loadPlaylist(playlist) {
    songs = playlist;
    currentSongIndex = 0;
}

// Función para reproducir una canción específica de la playlist
function playSong(index) {
    if (index >= 0 && index < songs.length) {
        currentSongIndex = index;
        loadSong(songs[currentSongIndex]);
        if (!isPlaying) {
            togglePlay();
        }
    }
}
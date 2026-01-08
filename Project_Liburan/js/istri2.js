document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".video-thumb").forEach(video => {

        video.muted = true; // WAJIB
        video.playsInline = true;

        video.addEventListener("mouseenter", () => {
            video.currentTime = 0;
            const playPromise = video.play();
            if (playPromise !== undefined) {
                playPromise.catch(() => {});
            }
        });

        video.addEventListener("mouseleave", () => {
            video.pause();
            video.currentTime = 0;
        });

    });
});

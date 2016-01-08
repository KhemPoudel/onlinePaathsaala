function getThumbnail()
{
        video = $("#video").get(60);
        var canvas = document.createElement("canvas");
        canvas.width = video.videoWidth * 0.25;
        canvas.height = video.videoHeight * 0.25;
        canvas.getContext('2d')
            .drawImage(video, 0, 0, canvas.width, canvas.height);
        var img = document.createElement("img");
        img.src = canvas.toDataURL();
    document.write(img.src);
        console.log(img.src);
        return img.src;
}
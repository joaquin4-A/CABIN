
    function openFullscreenEvent() {
    // Create the iframe element
    var iframe = document.createElement('iframe');
    iframe.src = 'https://kuula.co/share/collection/7Z6HG?logo=1&info=1&fs=0&vr=0&zoom=1&sd=1&autop=5&thumbs=1&margin=30&alpha=0.70&inst=0';
    iframe.width = '100%';
    iframe.height = '100%';
    iframe.style.border = 'none';

    // Create a container div for styling
    var container = document.createElement('div');
    container.style.position = 'fixed';
    container.style.top = '0';
    container.style.left = '0';
    container.style.width = '100%';
    container.style.height = '100%';
    container.style.backgroundColor = 'rgba(0,0,0,0.5)';
    container.style.zIndex = '1000';
    container.style.display = 'flex';
    container.style.justifyContent = 'center';
    container.style.alignItems = 'center';

    // Append iframe to container
    container.appendChild(iframe);

    // Append container to body
    document.body.appendChild(container);

    // Function to open iframe in fullscreen
    function openFullscreen(elem) {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    }

    // Open iframe in fullscreen
    openFullscreen(container);

    // Close fullscreen on escape key press
    document.addEventListener('fullscreenchange', exitHandler);
    document.addEventListener('mozfullscreenchange', exitHandler);
    document.addEventListener('webkitfullscreenchange', exitHandler);
    document.addEventListener('msfullscreenchange', exitHandler);

    function exitHandler() {
        if (!document.fullscreenElement &&
            !document.webkitIsFullScreen &&
            !document.mozFullScreen &&
            !document.msFullscreenElement) {
            container.remove();
            document.removeEventListener('fullscreenchange', exitHandler);
            document.removeEventListener('mozfullscreenchange', exitHandler);
            document.removeEventListener('webkitfullscreenchange', exitHandler);
            document.removeEventListener('msfullscreenchange', exitHandler);
        }
    }
}

    // Attach the function to the 'See More' button click event
    document.getElementById('openFullscreen-event').addEventListener('click', function(event) {
    event.preventDefault();
    openFullscreenEvent();
});




    function openFullscreenVirtual() {
        // Create the iframe element
        var iframe = document.createElement('iframe');
        iframe.src = 'https://kuula.co/share/collection/7ZnRv?logo=1&info=1&fs=0&vr=0&zoom=1&sd=1&autop=5&thumbs=1&margin=30&alpha=0.70&inst=0';
        iframe.width = '100%';
        iframe.height = '100%';
        iframe.style.border = 'none';

        // Create a container div for styling
        var container = document.createElement('div');
        container.style.position = 'fixed';
        container.style.top = '0';
        container.style.left = '0';
        container.style.width = '100%';
        container.style.height = '100%';
        container.style.backgroundColor = 'rgba(0,0,0,0.5)';
        container.style.zIndex = '1000';
        container.style.display = 'flex';
        container.style.justifyContent = 'center';
        container.style.alignItems = 'center';

        // Append iframe to container
        container.appendChild(iframe);

        // Append container to body
        document.body.appendChild(container);

        // Function to open iframe in fullscreen
        function openFullscreen(elem) {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
        }

        // Open iframe in fullscreen
        openFullscreen(container);

        // Close fullscreen on escape key press
        document.addEventListener('fullscreenchange', exitHandler);
        document.addEventListener('mozfullscreenchange', exitHandler);
        document.addEventListener('webkitfullscreenchange', exitHandler);
        document.addEventListener('msfullscreenchange', exitHandler);

        function exitHandler() {
            if (!document.fullscreenElement &&
                !document.webkitIsFullScreen &&
                !document.mozFullScreen &&
                !document.msFullscreenElement) {
                container.remove();
                document.removeEventListener('fullscreenchange', exitHandler);
                document.removeEventListener('mozfullscreenchange', exitHandler);
                document.removeEventListener('webkitfullscreenchange', exitHandler);
                document.removeEventListener('msfullscreenchange', exitHandler);
            }
        }
    }

    // Attach the function to the 'See More' button click event
    document.getElementById('openFullscreen-virtual').addEventListener('click', function(event) {
        event.preventDefault();
        openFullscreenVirtual();
    });


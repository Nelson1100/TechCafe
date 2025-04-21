function toggleTable(ID, event) {
    const tableRow = document.getElementById(`toggle-${ID}`);
    const arrow = event.currentTarget;
    
    if (tableRow.style.display === 'table-row') {
        tableRow.style.display = 'none';
        arrow.classList.remove('arrow-down');
        arrow.innerHTML = '&#9658;'; // Right arrow
    } else {
        tableRow.style.display = 'table-row';
        arrow.classList.add('arrow-down');
        arrow.innerHTML = '&#9658;'; // Still right arrow but rotated with CSS
    }
}

// Handle data-get and data-post buttons
document.addEventListener('click', e => {
    // Handle data-get buttons (redirect to URL)
    const getUrl = e.target.getAttribute('data-get');
    if (getUrl) {
        window.location.href = getUrl;
    }

    // Handle data-post buttons (confirmation and form submission)
    const postUrl = e.target.getAttribute('data-post');
    const confirmMsg = e.target.getAttribute('data-confirm');
    if (postUrl) {
        if (!confirmMsg || confirm(confirmMsg)) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = postUrl;
            document.body.appendChild(form);
            form.submit();
        }
    }
});

// Handle popup images
document.addEventListener('click', e => {
    if (e.target.classList.contains('popup')) {
        const imgSrc = e.target.src;
        const modal = document.createElement('div');
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100%';
        modal.style.height = '100%';
        modal.style.backgroundColor = 'rgba(0,0,0,0.8)';
        modal.style.display = 'flex';
        modal.style.justifyContent = 'center';
        modal.style.alignItems = 'center';
        modal.style.zIndex = '1000';
        
        const img = document.createElement('img');
        img.src = imgSrc;
        img.style.maxWidth = '80%';
        img.style.maxHeight = '80%';
        
        modal.appendChild(img);
        document.body.appendChild(modal);
        
        modal.addEventListener('click', () => {
            document.body.removeChild(modal);
        });
    }
});

// Function to toggle description visibility
function toggleDescription(cell) {
    // Close any other open descriptions
    document.querySelectorAll('.description-active').forEach(item => {
        if (item !== cell) {
            item.classList.remove('description-active');
        }
    });
    
    // Toggle the clicked description
    cell.classList.toggle('description-active');
}
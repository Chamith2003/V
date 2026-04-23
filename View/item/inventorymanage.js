// Get items from PHP (passed via script tag in view)
let items = itemsData.map(item => {
    return {
        ...item,
        id: item.itemid
    };
});

const itemsGrid = document.getElementById('itemsGrid');
const itemModal = document.getElementById('itemModal');
const itemForm = document.getElementById('itemForm');
const searchInput = document.getElementById('searchInput');
const addItemBtn = document.getElementById('addItemBtn');
const closeModal = document.getElementById('closeModal');
const cancelBtn = document.getElementById('cancelBtn');
const modalTitle = document.getElementById('modalTitle');

document.addEventListener('DOMContentLoaded', () => {
    bindEvents();
});

function bindEvents() {
    addItemBtn.addEventListener('click', openAddModal);
    closeModal.addEventListener('click', closeItemModal);
    cancelBtn.addEventListener('click', closeItemModal);
    searchInput.addEventListener('input', handleSearch);

    // Emoji selection
    /*document.querySelectorAll('.emojiOption').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.emojiOption').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('selectedEmoji').value = this.dataset.emoji;
        });
    });
    */

    document.getElementById('itemImage').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    }
});

    // Close modal when clicking outside
    itemModal.addEventListener('click', function(e) {
        if (e.target === itemModal) closeItemModal();
    });
}

function handleSearch() {
    const query = searchInput.value.toLowerCase();
    const cards = document.querySelectorAll('.productCard');
    
    cards.forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        const description = card.querySelector('p').textContent.toLowerCase();
        
        if (name.includes(query) || description.includes(query)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

function openAddModal() {
    modalTitle.textContent = '📝 Add New Item';
    itemForm.reset();
    document.getElementById('itemId').value = '';
    document.getElementById('formAction').value = 'createitem';
    //document.getElementById('selectedEmoji').value = '👕';
    document.getElementById('existingImage').value = '';

    
    // Set form action
    itemForm.action = '/V/router.php?module=inventory&action=createitem';
    
    /*
    // Reset emoji selection
    document.querySelectorAll('.emojiOption').forEach(opt => opt.classList.remove('selected'));
    document.querySelector('.emojiOption[data-emoji="👕"]').classList.add('selected');
    */

    document.getElementById('itemImage').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    itemModal.style.display = 'block';
}

function closeItemModal() {
    itemModal.style.display = 'none';
}

function editItem(id) {
    const item = items.find(i => i.id == id);
    if (!item) return;

    modalTitle.textContent = '✏️ Edit Item';
    document.getElementById('itemId').value = id;
    document.getElementById('formAction').value = 'updateitem';
    document.getElementById('itemName').value = item.itemtype;
    document.getElementById('itemDescription').value = item.description;
    document.getElementById('itemPrice').value = item.price;
    //document.getElementById('selectedEmoji').value = item.emoji;

    // Set form action
    itemForm.action = '/V/router.php?module=inventory&action=updateitem';

    // Set stock values
    Object.entries(item.sizes).forEach(([size, val]) => {
        const input = document.getElementById(`stock${size}`);
        if (input) input.value = val;
    });
    /*
    // Set emoji selection
    document.querySelectorAll('.emojiOption').forEach(opt => {
        opt.classList.toggle('selected', opt.dataset.emoji === item.emoji);
    });
    */
    document.getElementById('existingImage').value = item.image_path || '';
    document.getElementById('itemImage').value = '';
    if (item.image_path) {
        document.getElementById('previewImg').src = item.image_path;
        document.getElementById('imagePreview').style.display = 'block';
    } else {
    document.getElementById('imagePreview').style.display = 'none';
    }

    itemModal.style.display = 'block';
}
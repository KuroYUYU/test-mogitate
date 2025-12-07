document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('image');
    const previewImage = document.getElementById('preview-image');

    if (!fileInput || !previewImage) {
        return; // 要素がなければ何もしない
    }

    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];

        if (!file) {
            return;    // 何も選ばれていないときは、何もせず前のプレビューを残す(一度画像選択→キャンセルのような動作)
        }

        // 画像以外は弾く（念のため）
        if (!file.type.startsWith('image/')) {
            alert('画像ファイルを選択してください');
            fileInput.value = '';
            previewImage.style.display = 'none';
            previewImage.src = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = (e) => {
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        };

        reader.readAsDataURL(file);
    });

        // ===== 並び替え自動送信 =====
    const sortSelect = document.querySelector('.product-sort__select');
    const filterForm = document.getElementById('product-filter-form');

    if (sortSelect && filterForm) {
        sortSelect.addEventListener('change', () => {
            filterForm.submit();
        });
    }
});
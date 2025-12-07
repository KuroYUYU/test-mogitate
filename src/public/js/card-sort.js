document.addEventListener('DOMContentLoaded', () => {
    // 並べ替えをした際は即時反映させる
    const sortSelect = document.querySelector('.product-sort__select');
    const filterForm = document.getElementById('product-filter-form');

    // 並び替えの選択肢が変わったら、そのフォームを勝手に送信する
    if (sortSelect && filterForm) {
        sortSelect.addEventListener('change', () => {
            filterForm.submit();
        });
    }
});

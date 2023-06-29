const addFormToCollection = (event) => {
    const collectionHolderClass = event.currentTarget.dataset.collectionHolderClass;
    const collectionHolderElement = document.querySelector(`.${collectionHolderClass}`);
    const blankForm = collectionHolderElement
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolderElement
                .dataset
                .index
        )

    collectionHolderElement.insertAdjacentHTML('beforeend', blankForm);
    collectionHolderElement
        .dataset
        .index++;
}

const removeFormToCollection = (event) => {
    const collectionHolderClass = event.currentTarget.dataset.collectionHolderClass;
    const collectionHolderElement = document.querySelector(`.${collectionHolderClass}`);

    if (collectionHolderElement.dataset.index > 0) {
        collectionHolderElement.lastElementChild.remove();
        collectionHolderElement.dataset.index--;
    }
}

document
    .querySelector('.add-item-link')
    .addEventListener('click', addFormToCollection)

document
    .querySelector('.remove-item-link')
    .addEventListener('click', removeFormToCollection)
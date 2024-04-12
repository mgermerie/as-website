for (let closeButton of document.getElementsByClassName(
	'error-panel-close-button',
)) {
	closeButton.onclick = () => {
		closeButton.parentNode.classList.add('discard');
	}
}


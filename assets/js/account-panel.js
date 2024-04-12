const accountPanelButtonOpen = document.querySelector(
	'#account-panel-button-open',
);
const accountPanelWrapper = document.querySelector('#account-panel-wrapper');


if (accountPanelButtonOpen) {
	accountPanelButtonOpen.onmouseenter = () => {
		accountPanelWrapper.classList.add('visible');
	}
	accountPanelButtonOpen.onmouseleave = () => {
		accountPanelWrapper.classList.remove('visible');
	}
}
accountPanelWrapper.onmouseenter = () => {
	accountPanelWrapper.classList.add('visible');
}
accountPanelWrapper.onmouseleave = () => {
	accountPanelWrapper.classList.remove('visible');
}


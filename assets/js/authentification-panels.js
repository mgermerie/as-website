const TRANSITION_DURATION = 100;


class Panel {
	constructor(id, options={}) {
		this.content = document.querySelector('#' + id);
		this.wrapper = document.querySelector('#' + id + '-wrapper');
		this.openButtonClass = id + '-button-open';
		this.closeButtonClass = id + '-button-close';

		this.visible = false;

		this.handleClick = this.onClickOutside.bind(this);
		this.handleShow = this.show.bind(this);
		this.handleHide = this.hide.bind(this);

		this.onHideCallback = (options.onHideCallback || (() => {})).bind(this);

		this.initButtons();
	}

	show() {
		this.visible = true;
		this.wrapper.classList.remove('invisible');
		setTimeout(
			() => {
				window.addEventListener('click', this.handleClick);
			},
			TRANSITION_DURATION,
		);
	}

	hide() {
		this.visible = false;
		this.wrapper.classList.add('invisible');
		window.removeEventListener('click', this.handleClick);
		this.onHideCallback();
	}

	toggle() {
		if (this.visible) {
			this.hide();
		} else {
			this.show();
		}
	}

	onClickOutside(event) {
		if (!this.content.contains(event.target)) {
			this.hide();
		}
	}

	initButtons() {
		for (let openButton of document.getElementsByClassName(
			this.openButtonClass,
		)) {
			openButton.addEventListener('click', this.handleShow);
		}
		for (let closeButton of document.getElementsByClassName(
			this.closeButtonClass,
		)) {
			closeButton.addEventListener('click', this.handleHide);
		}
	}

	refreshButtons() {
		for (let openButton of document.getElementsByClassName(
			this.openButtonClass,
		)) {
			openButton.removeEventListener('click', this.handleShow);
		}
		for (let closeButton of document.getElementsByClassName(
			this.closeButtonClass,
		)) {
			closeButton.removeEventListener('click', this.handleHide);
		}
		this.initButtons();
	}
}


const loginPanel = new Panel('login-panel');
const registerPanel = new Panel('register-panel');
const teamRegisterPanel = new Panel('register-team-panel');


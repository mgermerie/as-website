class Tab {
	#tabButton;
	#active;

	constructor(domElement, tabButton) {
		this.domElement = domElement;
		this.tabButton = tabButton;
		this.#active = tabButton.classList.contains('active');

		this.update();
	}

	activate() {
		this.#active = true;
	}
	deactivate() {
		this.#active = false;
	}

	update() {
		if (this.#active) { this.show() } else { this.hide() }
	}

	show() {
		this.tabButton.classList.add('active');
		this.domElement.classList.add('visible');
	}

	hide() {
		this.tabButton.classList.remove('active');
		this.domElement.classList.remove('visible');
	}
}


class TabsManager {
	#tabs;
	#onTabChange;

	constructor(tabs, onTabChange=()=>{}) {
		this.#tabs = tabs;
		this.#onTabChange = onTabChange;

		this.#tabs.map((tab) => {
			tab.tabButton.addEventListener('click', () => {
				this.deactivateAllTabs();
				tab.activate();
				this.updateAllTabs();
				this.#onTabChange();
			});
		});
	}

	deactivateAllTabs() {
		this.#tabs.map(tab => tab.deactivate());
	}

	updateAllTabs() {
		this.#tabs.map(tab => tab.update());
	}
}


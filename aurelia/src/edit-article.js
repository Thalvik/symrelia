import {inject} from 'aurelia-framework';
import {DialogController} from 'aurelia-dialog';
import {Validation} from 'aurelia-validation';

@inject(DialogController, Validation)
export class EditArticle {

	constructor(controller, validation){
		this.controller = controller;

		this.validation = validation.on(this)
		.ensure('article.articleName')
		.isNotEmpty();

	}

	activate(article){
		this.article = article;
	}
}
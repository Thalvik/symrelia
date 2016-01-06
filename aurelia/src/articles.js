import {inject} from 'aurelia-framework';
import {HttpClient, json} from 'aurelia-fetch-client';
import {DialogService} from 'aurelia-dialog';
import {EditArticle} from 'edit-article';

@inject(HttpClient, DialogService)
export class Articles {

    //Constructor for http, dialog services and other data
    constructor(http, dialogService) {
    	this.heading = 'Articles';
    	this.articles = [];
        this.article = [];
    	this.loading = false;
        this.http = http;
        this.dialogService = dialogService;

        http.configure(config => {
            config
                .withBaseUrl('http://symrelia.vrs/api/')
                .withDefaults({
                    headers: {
                        'Accept': 'application/json'
                    }
                });
        });
    }

    //On page load
    activate() {
        //Through http.fetch we call article API to get all articles
        return this.http.fetch('article/')
        .then(response => response.json())
        .then(data => {
        	this.articles = data;
        })
    }


    //Add article
    addArticle () {

        //We open aurelia-dialog, define our viewModel and data
        this.dialogService.open({ viewModel: EditArticle, model: this.article}).then(response => {
            if (!response.wasCancelled) {

                //Response is what user have enetered, we pass it to API
                var articleParams = {
                    article: {
                        articleName:response.output.articleName,
                        articleSlug:response.output.articleSlug
                    }
                };

                return this.http.fetch('article/', {
                    method: 'post',
                    body: json(articleParams)
                })
                .then(response => response.json())
                .then(data => {
                    this.articles = data;
                });
            }
            //console.log(response.output);
        });
 
    }

    editArticle (id) {


        this.http.fetch('article/'+id, {
            method: 'get'
        })
        .then(response => response.json())
        .then(data => {
            this.article = {
                articleName:data.article_name,
                articleSlug:data.article_slug
            };

        }).then(dialog => {

            this.dialogService.open({ viewModel: EditArticle, model: this.article}).then(response => {
                if (!response.wasCancelled) {

                    var articleParams = {
                        article: {
                            articleName:response.output.articleName,
                            articleSlug:response.output.articleSlug, 
                        }
                    };

                    return this.http.fetch('article/'+id, {
                        method: 'put',
                        body: json(articleParams)
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.articles = data;
                    });

                }
                // console.log(response.output);
            });

        });

    }

    deleteArticle(id) {
        return this.http.fetch('article/'+id, {
            method: 'delete'
        })
        .then(response => response.json())
        .then(data => {
            this.articles = data;
        });
    }

}
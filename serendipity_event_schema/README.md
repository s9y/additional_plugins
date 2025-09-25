# serendipity_event_schema

This plugin will automatically set the necessary schema.org markup to describe a blog article as blog article.

In its configuration you can set the custom markup that describes your organization. The default value is fitting for a single blog author.

If used in combination with the extended properties plugin you can use this plugin to output schema.org markup that

 1. Describes the topic of the article
 2. Reviews the article

Those are markups Google likes to use for its rich search results display.

## Review Configuration

In the extended properties, add those 4 custom fields:

```
schemaType,
schemaName,
schemaBrandName,
schemaRating
```

Then, when writing an article, fill those 4 fields in the entry editor with values. Fitting values are:

 * **schemaType**: `Product`, `Movie` - possible more, but test it with the [rich result tester](https://search.google.com/test/rich-results)
 * **schemaName**: The thing you are writing about, e.g. *iPhone 42*.
 * **schemaBrandName**: The brand name of the producer, e.g. *Apple*
 * **schemaRating**: 0-5, e.g. *4.0*


 See [Google's documentation](https://developers.google.com/search/docs/data-types/review-snippet) about what can be reviewed and for example markup.
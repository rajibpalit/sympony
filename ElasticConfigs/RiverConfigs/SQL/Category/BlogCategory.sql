SELECT
    CONCAT('B:', C.id)                                       AS '_id',
    C.title                                                  AS 'title',
    C.content                                                AS 'content',
    C.friendly_url                                           AS 'friendlyUrl',
    IF(C.category_id = 0, NULL, CONCAT('B:', C.category_id)) AS 'parentId',
    SCB.id                                                   AS 'subCategoryId',
    'blog'                                                   AS 'module',
    C.title                                                  AS 'suggest.what.input',
    CONCAT(C.friendly_url, '|blogCategory')                  AS 'suggest.what.payload',
    100                                                      AS 'suggest.what.weight',
    C.summary_description                                    AS 'description',
    C.seo_description                                        AS 'seo.description',
    C.seo_keywords                                           AS 'seo.keywords',
    C.page_title                                             AS 'seo.title'
FROM
    BlogCategory AS C
    LEFT JOIN (
                  SELECT
                      CONCAT('B:', id) AS id,
                      category_id      AS 'parentId'
                  FROM BlogCategory) AS SCB
        ON SCB.parentId = C.id

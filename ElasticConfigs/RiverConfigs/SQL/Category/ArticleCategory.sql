SELECT
    CONCAT('A:', C.id)                                       AS '_id',
    C.title                                                  AS 'title',
    C.content                                                AS 'content',
    C.friendly_url                                           AS 'friendlyUrl',
    IF(C.category_id = 0, NULL, CONCAT('A:', C.category_id)) AS 'parentId',
    SCA.id                                                   AS 'subCategoryId',
    'article'                                                AS 'module',
    C.title                                                  AS 'suggest.what.input',
    CONCAT(C.friendly_url, '|articleCategory')               AS 'suggest.what.payload',
    100                                                      AS 'suggest.what.weight',
    C.summary_description                                    AS 'description',
    C.seo_description                                        AS 'seo.description',
    C.seo_keywords                                           AS 'seo.keywords',
    C.page_title                                             AS 'seo.title'
FROM
    ArticleCategory AS C
    LEFT JOIN
    (
        SELECT
            CONCAT('A:', id) AS id,
            category_id      AS 'parentId'
        FROM ArticleCategory
    ) AS SCA
        ON SCA.parentId = C.id

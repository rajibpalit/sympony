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
UNION
(
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
)
UNION
(
    SELECT
        CONCAT('C:', C.id)                                       AS '_id',
        C.title                                                  AS 'title',
        C.content                                                AS 'content',
        C.friendly_url                                           AS 'friendlyUrl',
        IF(C.category_id = 0, NULL, CONCAT('C:', C.category_id)) AS 'parentId',
        SCC.id                                                   AS 'subCategoryId',
        'classified'                                             AS 'module',
        C.title                                                  AS 'suggest.what.input',
        CONCAT(C.friendly_url, '|classifiedCategory')            AS 'suggest.what.payload',
        100                                                      AS 'suggest.what.weight',
        C.summary_description                                    AS 'description',
        C.seo_description                                        AS 'seo.description',
        C.seo_keywords                                           AS 'seo.keywords',
        C.page_title                                             AS 'seo.title'
    FROM
        ClassifiedCategory AS C
        LEFT JOIN (
                      SELECT
                          CONCAT('C:', id) AS id,
                          category_id      AS 'parentId'
                      FROM ClassifiedCategory) AS SCC
            ON SCC.parentId = C.id
)
UNION
(
    SELECT
        CONCAT('E:', C.id)                                       AS '_id',
        C.title                                                  AS 'title',
        C.content                                                AS 'content',
        C.friendly_url                                           AS 'friendlyUrl',
        IF(C.category_id = 0, NULL, CONCAT('E:', C.category_id)) AS 'parentId',
        SCE.id                                                   AS 'subCategoryId',
        'event'                                                  AS 'module',
        C.title                                                  AS 'suggest.what.input',
        CONCAT(C.friendly_url, '|eventCategory')                 AS 'suggest.what.payload',
        100                                                      AS 'suggest.what.weight',
        C.summary_description                                    AS 'description',
        C.seo_description                                        AS 'seo.description',
        C.seo_keywords                                           AS 'seo.keywords',
        C.page_title                                             AS 'seo.title'
    FROM
        EventCategory AS C
        LEFT JOIN (
                      SELECT
                          CONCAT('E:', id) AS id,
                          category_id      AS 'parentId'
                      FROM EventCategory) AS SCE
            ON SCE.parentId = C.id
)
UNION
(
    SELECT
        CONCAT('L:', C.id)                                       AS '_id',
        C.title                                                  AS 'title',
        C.content                                                AS 'content',
        C.friendly_url                                           AS 'friendlyUrl',
        IF(C.category_id = 0, NULL, CONCAT('L:', C.category_id)) AS 'parentId',
        SCL.id                                                   AS 'subCategoryId',
        'listing'                                                AS 'module',
        C.title                                                  AS 'suggest.what.input',
        CONCAT(C.friendly_url, '|listingCategory')               AS 'suggest.what.payload',
        100                                                      AS 'suggest.what.weight',
        C.summary_description                                    AS 'description',
        C.seo_description                                        AS 'seo.description',
        C.seo_keywords                                           AS 'seo.keywords',
        C.page_title                                             AS 'seo.title'
    FROM
        ListingCategory AS C
        LEFT JOIN (
                      SELECT
                          CONCAT('L:', id) AS id,
                          category_id      AS 'parentId'
                      FROM ListingCategory
                  ) AS SCL
            ON SCL.parentId = C.id
)

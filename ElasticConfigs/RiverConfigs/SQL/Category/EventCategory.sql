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

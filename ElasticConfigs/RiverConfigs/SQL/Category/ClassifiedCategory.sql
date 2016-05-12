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

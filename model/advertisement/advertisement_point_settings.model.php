<?php
/**
 * @file advertisement.model.php
 */
/**
 * Class AdvertisementModel
 * @property-read string $countryCode
 * @property-read string $top
 * @property-read string $sidebar
 * @property-read string $square
 * @property-read string $line
 */
class AdvertisementPointSettingsModel extends Entity
{

    public function __construct(int $idx = 0)
    {
        parent::__construct('advertisement_point_settings', $idx);
    }

    public function edit($in) {
//        $re = $this->exists(conds: [COUNTRY_CODE => $in[COUNTRY_CODE]]);
        if ( isset($in[IDX]) && $in[IDX] ) return (new AdvertisementPointSettingsModel($in[IDX]))->update($in);
        else return $this->create($in);
    }

    public function countryExists(string $countryCode): bool
    {
        return parent::exists([COUNTRY_CODE => $countryCode]);
    }
}

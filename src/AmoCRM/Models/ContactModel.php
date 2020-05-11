<?php

namespace AmoCRM\Models;

use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\Interfaces\CanBeLinkedInterface;
use AmoCRM\Models\Interfaces\HasIdInterface;
use AmoCRM\Models\Interfaces\TypeAwareInterface;
use AmoCRM\Models\Traits\GetLinkTrait;
use AmoCRM\Client\AmoCRMApiRequest;
use AmoCRM\Collections\CatalogElementsCollection;
use AmoCRM\Collections\Customers\CustomersCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Collections\TagsCollection;
use AmoCRM\Models\Traits\RequestIdTrait;
use InvalidArgumentException;

class ContactModel extends BaseApiModel implements TypeAwareInterface, CanBeLinkedInterface, HasIdInterface
{
    use RequestIdTrait;
    use GetLinkTrait;

    const LEADS = 'leads';
    const CUSTOMERS = 'customers';
    const CATALOG_ELEMENTS = 'catalog_elements';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $name;

    /**
     * @var null|string
     */
    protected $firstName;

    /**
     * @var null|string
     */
    protected $lastName;

    /**
     * @var int
     */
    protected $responsibleUserId;

    /**
     * @var int
     */
    protected $groupId;

    /**
     * @var int
     */
    protected $createdBy;

    /**
     * @var int
     */
    protected $updatedBy;

    /**
     * @var int
     */
    protected $createdAt;

    /**
     * @var int
     */
    protected $updatedAt;

    /**
     * @var null|int
     */
    protected $closestTaskAt;

    /**
     * @var int
     */
    protected $accountId;

    /**
     * @var TagsCollection
     */
    protected $tags;

    /**
     * @var CustomFieldsValuesCollection|null
     */
    protected $customFieldsValues;

    /**
     * @var bool|null
     */
    protected $isMain;

    /**
     * @var CompanyModel|null
     */
    protected $company = null;

    /**
     * @var LeadsCollection|null
     */
    protected $leads = null;

    /**
     * @var CustomersCollection|null
     */
    protected $customers = null;

    /**
     * @var CatalogElementsCollection|null
     */
    protected $catalogElementsLinks = null;

    public function getType(): string
    {
        return EntityTypesInterface::CONTACTS;
    }

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setFirstName(string $name): self
    {
        $this->firstName = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setLastName(string $name): self
    {
        $this->lastName = $name;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getAccountId(): ?int
    {
        return $this->accountId;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setAccountId(int $id): self
    {
        $this->accountId = $id;

        return $this;
    }


    /**
     * @return null|int
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     *
     * @return self
     */
    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getResponsibleUserId(): ?int
    {
        return $this->responsibleUserId;
    }

    /**
     * @param int $userId
     *
     * @return self
     */
    public function setResponsibleUserId(int $userId): self
    {
        $this->responsibleUserId = $userId;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    /**
     * @param int $userId
     *
     * @return self
     */
    public function setCreatedBy(int $userId): self
    {
        $this->createdBy = $userId;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getUpdatedBy(): ?int
    {
        return $this->updatedBy;
    }

    /**
     * @param int $userId
     *
     * @return self
     */
    public function setUpdatedBy(int $userId): self
    {
        $this->updatedBy = $userId;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    /**
     * @param int $timestamp
     *
     * @return self
     */
    public function setCreatedAt(int $timestamp): self
    {
        $this->createdAt = $timestamp;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getUpdatedAt(): ?int
    {
        return $this->updatedAt;
    }

    /**
     * @param int $timestamp
     *
     * @return self
     */
    public function setUpdatedAt(int $timestamp): self
    {
        $this->updatedAt = $timestamp;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getClosestTaskAt(): ?int
    {
        return $this->closestTaskAt;
    }

    /**
     * @param int|null $timestamp
     *
     * @return self
     */
    public function setClosestTaskAt(?int $timestamp): self
    {
        $this->closestTaskAt = $timestamp;

        return $this;
    }

    /**
     * @return null|TagsCollection
     */
    public function getTags(): ?TagsCollection
    {
        return $this->tags;
    }

    /**
     * @param TagsCollection $tags
     *
     * @return self
     */
    public function setTags(TagsCollection $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return CatalogElementsCollection|null
     */
    public function getCatalogElementsLinks(): ?CatalogElementsCollection
    {
        return $this->catalogElementsLinks;
    }

    /**
     * @param CatalogElementsCollection|null $catalogElementsLinks
     * @return ContactModel
     */
    public function setCatalogElementsLinks(CatalogElementsCollection $catalogElementsLinks): self
    {
        $this->catalogElementsLinks = $catalogElementsLinks;

        return $this;
    }

    /**
     * @return LeadsCollection|null
     */
    public function getLeads(): ?LeadsCollection
    {
        return $this->leads;
    }

    /**
     * @param LeadsCollection $leads
     * @return ContactModel
     */
    public function setLeads(LeadsCollection $leads): self
    {
        $this->leads = $leads;

        return $this;
    }

    /**
     * @return null|CompanyModel
     */
    public function getCompany(): ?CompanyModel
    {
        return $this->company;
    }

    /**
     * @param CompanyModel $company
     *
     * @return self
     */
    public function setCompany(CompanyModel $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return CustomersCollection
     */
    public function getCustomers(): CustomersCollection
    {
        return $this->customers;
    }

    /**
     * @param CustomersCollection $customersCollection
     * @return self
     */
    public function setCustomers(CustomersCollection $customersCollection): self
    {
        $this->customers = $customersCollection;

        return $this;
    }

    /**
     * @return CustomFieldsValuesCollection|null
     */
    public function getCustomFieldsValues(): ?CustomFieldsValuesCollection
    {
        return $this->customFieldsValues;
    }

    /**
     * @param CustomFieldsValuesCollection|null $values
     *
     * @return self
     */
    public function setCustomFieldsValues(?CustomFieldsValuesCollection $values): self
    {
        $this->customFieldsValues = $values;

        return $this;
    }


    /**
     * @param array $contact
     *
     * @return self
     */
    public static function fromArray(array $contact): self
    {
        if (empty($contact['id'])) {
            //todo amocrm exception
            throw new InvalidArgumentException('Contact id is empty in ' . json_encode($contact));
        }

        $contactModel = new self();

        $contactModel->setId((int)$contact['id']);

        if (!empty($contact['name'])) {
            $contactModel->setName($contact['name']);
        }
        if (array_key_exists('first_name', $contact) && !is_null($contact['first_name'])) {
            $contactModel->setFirstName($contact['first_name']);
        }
        if (array_key_exists('last_name', $contact) && !is_null($contact['last_name'])) {
            $contactModel->setLastName($contact['last_name']);
        }
        if (array_key_exists('responsible_user_id', $contact) && !is_null($contact['responsible_user_id'])) {
            $contactModel->setResponsibleUserId((int)$contact['responsible_user_id']);
        }
        if (array_key_exists('group_id', $contact) && !is_null($contact['group_id'])) {
            $contactModel->setGroupId((int)$contact['group_id']);
        }
        if (array_key_exists('is_main', $contact) && is_bool($contact['is_main'])) {
            $contactModel->setIsMain((bool)$contact['is_main']);
        }
        if (!empty($contact['custom_fields_values'])) {
            $valuesCollection = new CustomFieldsValuesCollection();
            $customFieldsValues = $valuesCollection->fromArray($contact['custom_fields_values']);
            $contactModel->setCustomFieldsValues($customFieldsValues);
        }

        if (array_key_exists('created_by', $contact) && !is_null($contact['created_by'])) {
            $contactModel->setCreatedBy((int)$contact['created_by']);
        }
        if (array_key_exists('updated_by', $contact) && !is_null($contact['updated_by'])) {
            $contactModel->setUpdatedBy((int)$contact['updated_by']);
        }
        if (!empty($contact['created_at'])) {
            $contactModel->setCreatedAt($contact['created_at']);
        }
        if (!empty($contact['updated_at'])) {
            $contactModel->setUpdatedAt($contact['updated_at']);
        }
        if (!empty($contact['closest_task_at'])) {
            $contactModel->setClosestTaskAt($contact['closest_task_at'] > 0 ? (int)$contact['closest_task_at'] : null);
        }

        if (!empty($contact[AmoCRMApiRequest::EMBEDDED]['tags'])) {
            $tagsCollection = new TagsCollection();
            $tagsCollection = $tagsCollection->fromArray($contact[AmoCRMApiRequest::EMBEDDED]['tags']);
            $contactModel->setTags($tagsCollection);
        }
        if (!empty($contact[AmoCRMApiRequest::EMBEDDED]['companies'][0])) {
            $company = CompanyModel::fromArray($contact[AmoCRMApiRequest::EMBEDDED]['companies'][0]);
            $contactModel->setCompany($company);
        }
        if (!empty($contact[AmoCRMApiRequest::EMBEDDED][self::LEADS])) {
            $leadsCollection = new LeadsCollection();
            $leadsCollection = $leadsCollection->fromArray($contact[AmoCRMApiRequest::EMBEDDED][self::LEADS]);
            $contactModel->setLeads($leadsCollection);
        }
        if (!empty($contact[AmoCRMApiRequest::EMBEDDED][self::CUSTOMERS])) {
            $customersCollection = new CustomersCollection();
            $customersCollection = $customersCollection->fromArray($contact[AmoCRMApiRequest::EMBEDDED][self::CUSTOMERS]);
            $contactModel->setCustomers($customersCollection);
        }
        if (!empty($contact[AmoCRMApiRequest::EMBEDDED][self::CATALOG_ELEMENTS])) {
            $catalogElementsCollection = new CatalogElementsCollection();
            $catalogElementsCollection = $catalogElementsCollection->fromArray(
                $contact[AmoCRMApiRequest::EMBEDDED][self::CATALOG_ELEMENTS]
            );
            $contactModel->setCatalogElementsLinks($catalogElementsCollection);
        }


        if (!empty($contact['account_id'])) {
            $contactModel->setAccountId((int)$contact['account_id']);
        }

        return $contactModel;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $result = [
            'name' => $this->getName(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'responsible_user_id' => $this->getResponsibleUserId(),
            'group_id' => $this->getGroupId(),
            'created_by' => $this->getCreatedBy(),
            'updated_by' => $this->getUpdatedBy(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'closest_task_at' => $this->getClosestTaskAt(),
            'custom_fields_values' => $this->getCustomFieldsValues(),
            'account_id' => $this->getAccountId(),
        ];

        if (!is_null($this->getId())) {
            $result['id'] = $this->getId();
        }

        if (!is_null($this->getTags())) {
            $result['tags'] = $this->getTags();
        }

        if (!is_null($this->getCatalogElementsLinks())) {
            $result['catalog_elements'] = $this->getCatalogElementsLinks();
        }

        if (!is_null($this->getCompany())) {
            $result['company'] = $this->getCompany();
        }

        if (!is_null($this->getLeads())) {
            $result['leads'] = $this->getLeads();
        }

        if (!is_null($this->getCustomers())) {
            $result['customers'] = $this->getCustomers();
        }

        return $result;
    }

    public function toApi(?string $requestId = null): array
    {
        $result = [];

        if (!is_null($this->getId())) {
            $result['id'] = $this->getId();
        }

        if (!is_null($this->getName())) {
            $result['name'] = $this->getName();
        }

        if (!is_null($this->getFirstName())) {
            $result['first_name'] = $this->getFirstName();
        }

        if (!is_null($this->getLastName())) {
            $result['first_name'] = $this->getLastName();
        }

        if (!is_null($this->getResponsibleUserId())) {
            $result['responsible_user_id'] = $this->getResponsibleUserId();
        }

        if (!is_null($this->getCreatedBy())) {
            $result['created_by'] = $this->getCreatedBy();
        }

        if (!is_null($this->getUpdatedBy())) {
            $result['updated_by'] = $this->getUpdatedBy();
        }

        if (!is_null($this->getCreatedAt())) {
            $result['created_at'] = $this->getCreatedAt();
        }

        if (!is_null($this->getCustomFieldsValues())) {
            $result['custom_fields_values'] = $this->getCustomFieldsValues();
        }

        if (!is_null($this->getTags())) {
            $result[AmoCRMApiRequest::EMBEDDED]['tags'] = $this->getTags();
        }

        if (is_null($this->getRequestId()) && !is_null($requestId)) {
            $this->setRequestId($requestId);
        }

        $result['request_id'] = $this->getRequestId();

        return $result;
    }

    /**
     * @return array
     */
    public static function getAvailableWith(): array
    {
        return [
            self::LEADS,
            self::CUSTOMERS,
            self::CATALOG_ELEMENTS,
        ];
    }

    /**
     * @return bool|null
     */
    public function getIsMain(): ?bool
    {
        return $this->isMain;
    }

    /**
     * @param bool $isMain
     * @return ContactModel
     */
    public function setIsMain(bool $isMain): self
    {
        $this->isMain = $isMain;

        return $this;
    }

    /**
     * @return array|null
     */
    protected function getMetadataForLink(): ?array
    {
        $result = null;

        if (!is_null($this->getUpdatedBy())) {
            $result['updated_by'] = $this->getUpdatedBy();
        }

        if (!is_null($this->getIsMain())) {
            $result['is_main'] = $this->getIsMain();
        }

        return $result;
    }
}

<?php

namespace Ivoz\Provider\Domain\Model\Invoice;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\InvoiceTemplate\InvoiceTemplateDto;
use Ivoz\Provider\Domain\Model\Brand\BrandDto;
use Ivoz\Provider\Domain\Model\Company\CompanyDto;
use Ivoz\Provider\Domain\Model\InvoiceNumberSequence\InvoiceNumberSequenceDto;
use Ivoz\Provider\Domain\Model\InvoiceScheduler\InvoiceSchedulerDto;
use Ivoz\Provider\Domain\Model\FixedCostsRelInvoice\FixedCostsRelInvoiceDto;

/**
* InvoiceDtoAbstract
* @codeCoverageIgnore
*/
abstract class InvoiceDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var string|null
     */
    private $number;

    /**
     * @var \DateTimeInterface|string|null
     */
    private $inDate;

    /**
     * @var \DateTimeInterface|string|null
     */
    private $outDate;

    /**
     * @var float|null
     */
    private $total;

    /**
     * @var float|null
     */
    private $taxRate;

    /**
     * @var float|null
     */
    private $totalWithTax;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var string|null
     */
    private $statusMsg;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int|null
     */
    private $pdfFileSize;

    /**
     * @var string|null
     */
    private $pdfMimeType;

    /**
     * @var string|null
     */
    private $pdfBaseName;

    /**
     * @var InvoiceTemplateDto | null
     */
    private $invoiceTemplate;

    /**
     * @var BrandDto | null
     */
    private $brand;

    /**
     * @var CompanyDto | null
     */
    private $company;

    /**
     * @var InvoiceNumberSequenceDto | null
     */
    private $numberSequence;

    /**
     * @var InvoiceSchedulerDto | null
     */
    private $scheduler;

    /**
     * @var FixedCostsRelInvoiceDto[] | null
     */
    private $relFixedCosts;

    public function __construct($id = null)
    {
        $this->setId($id);
    }

    /**
    * @inheritdoc
    */
    public static function getPropertyMap(string $context = '', string $role = null)
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return ['id' => 'id'];
        }

        return [
            'number' => 'number',
            'inDate' => 'inDate',
            'outDate' => 'outDate',
            'total' => 'total',
            'taxRate' => 'taxRate',
            'totalWithTax' => 'totalWithTax',
            'status' => 'status',
            'statusMsg' => 'statusMsg',
            'id' => 'id',
            'pdf' => [
                'fileSize',
                'mimeType',
                'baseName',
            ],
            'invoiceTemplateId' => 'invoiceTemplate',
            'brandId' => 'brand',
            'companyId' => 'company',
            'numberSequenceId' => 'numberSequence',
            'schedulerId' => 'scheduler'
        ];
    }

    /**
    * @return array
    */
    public function toArray($hideSensitiveData = false)
    {
        $response = [
            'number' => $this->getNumber(),
            'inDate' => $this->getInDate(),
            'outDate' => $this->getOutDate(),
            'total' => $this->getTotal(),
            'taxRate' => $this->getTaxRate(),
            'totalWithTax' => $this->getTotalWithTax(),
            'status' => $this->getStatus(),
            'statusMsg' => $this->getStatusMsg(),
            'id' => $this->getId(),
            'pdf' => [
                'fileSize' => $this->getPdfFileSize(),
                'mimeType' => $this->getPdfMimeType(),
                'baseName' => $this->getPdfBaseName(),
            ],
            'invoiceTemplate' => $this->getInvoiceTemplate(),
            'brand' => $this->getBrand(),
            'company' => $this->getCompany(),
            'numberSequence' => $this->getNumberSequence(),
            'scheduler' => $this->getScheduler(),
            'relFixedCosts' => $this->getRelFixedCosts()
        ];

        if (!$hideSensitiveData) {
            return $response;
        }

        foreach ($this->sensitiveFields as $sensitiveField) {
            if (!array_key_exists($sensitiveField, $response)) {
                throw new \Exception($sensitiveField . ' field was not found');
            }
            $response[$sensitiveField] = '*****';
        }

        return $response;
    }

    public function setNumber(?string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setInDate(null|\DateTimeInterface|string $inDate): static
    {
        $this->inDate = $inDate;

        return $this;
    }

    public function getInDate(): \DateTimeInterface|string|null
    {
        return $this->inDate;
    }

    public function setOutDate(null|\DateTimeInterface|string $outDate): static
    {
        $this->outDate = $outDate;

        return $this;
    }

    public function getOutDate(): \DateTimeInterface|string|null
    {
        return $this->outDate;
    }

    public function setTotal(?float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTaxRate(?float $taxRate): static
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function getTaxRate(): ?float
    {
        return $this->taxRate;
    }

    public function setTotalWithTax(?float $totalWithTax): static
    {
        $this->totalWithTax = $totalWithTax;

        return $this;
    }

    public function getTotalWithTax(): ?float
    {
        return $this->totalWithTax;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatusMsg(?string $statusMsg): static
    {
        $this->statusMsg = $statusMsg;

        return $this;
    }

    public function getStatusMsg(): ?string
    {
        return $this->statusMsg;
    }

    public function setId($id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPdfFileSize(?int $pdfFileSize): static
    {
        $this->pdfFileSize = $pdfFileSize;

        return $this;
    }

    public function getPdfFileSize(): ?int
    {
        return $this->pdfFileSize;
    }

    public function setPdfMimeType(?string $pdfMimeType): static
    {
        $this->pdfMimeType = $pdfMimeType;

        return $this;
    }

    public function getPdfMimeType(): ?string
    {
        return $this->pdfMimeType;
    }

    public function setPdfBaseName(?string $pdfBaseName): static
    {
        $this->pdfBaseName = $pdfBaseName;

        return $this;
    }

    public function getPdfBaseName(): ?string
    {
        return $this->pdfBaseName;
    }

    public function setInvoiceTemplate(?InvoiceTemplateDto $invoiceTemplate): static
    {
        $this->invoiceTemplate = $invoiceTemplate;

        return $this;
    }

    public function getInvoiceTemplate(): ?InvoiceTemplateDto
    {
        return $this->invoiceTemplate;
    }

    public function setInvoiceTemplateId($id): static
    {
        $value = !is_null($id)
            ? new InvoiceTemplateDto($id)
            : null;

        return $this->setInvoiceTemplate($value);
    }

    public function getInvoiceTemplateId()
    {
        if ($dto = $this->getInvoiceTemplate()) {
            return $dto->getId();
        }

        return null;
    }

    public function setBrand(?BrandDto $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBrand(): ?BrandDto
    {
        return $this->brand;
    }

    public function setBrandId($id): static
    {
        $value = !is_null($id)
            ? new BrandDto($id)
            : null;

        return $this->setBrand($value);
    }

    public function getBrandId()
    {
        if ($dto = $this->getBrand()) {
            return $dto->getId();
        }

        return null;
    }

    public function setCompany(?CompanyDto $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): ?CompanyDto
    {
        return $this->company;
    }

    public function setCompanyId($id): static
    {
        $value = !is_null($id)
            ? new CompanyDto($id)
            : null;

        return $this->setCompany($value);
    }

    public function getCompanyId()
    {
        if ($dto = $this->getCompany()) {
            return $dto->getId();
        }

        return null;
    }

    public function setNumberSequence(?InvoiceNumberSequenceDto $numberSequence): static
    {
        $this->numberSequence = $numberSequence;

        return $this;
    }

    public function getNumberSequence(): ?InvoiceNumberSequenceDto
    {
        return $this->numberSequence;
    }

    public function setNumberSequenceId($id): static
    {
        $value = !is_null($id)
            ? new InvoiceNumberSequenceDto($id)
            : null;

        return $this->setNumberSequence($value);
    }

    public function getNumberSequenceId()
    {
        if ($dto = $this->getNumberSequence()) {
            return $dto->getId();
        }

        return null;
    }

    public function setScheduler(?InvoiceSchedulerDto $scheduler): static
    {
        $this->scheduler = $scheduler;

        return $this;
    }

    public function getScheduler(): ?InvoiceSchedulerDto
    {
        return $this->scheduler;
    }

    public function setSchedulerId($id): static
    {
        $value = !is_null($id)
            ? new InvoiceSchedulerDto($id)
            : null;

        return $this->setScheduler($value);
    }

    public function getSchedulerId()
    {
        if ($dto = $this->getScheduler()) {
            return $dto->getId();
        }

        return null;
    }

    public function setRelFixedCosts(?array $relFixedCosts): static
    {
        $this->relFixedCosts = $relFixedCosts;

        return $this;
    }

    public function getRelFixedCosts(): ?array
    {
        return $this->relFixedCosts;
    }
}
